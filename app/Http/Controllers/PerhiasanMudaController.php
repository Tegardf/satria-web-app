<?php

namespace App\Http\Controllers;

use App\Models\Gesek;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Penjualan_lain;
use App\Models\Perhiasan;
use App\Models\Pricelists;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PerhiasanMudaController extends Controller
{
    public function penjualan() {
        $stocksRaw = Stock::with(['penjualans', 'produk'])->whereHas('perhiasan', function ($query) {
            $query->where('jenis', 'Perhiasan Muda');
        })->paginate(10);
        $stocksNormal = Stock::with(['penjualans', 'produk'])->whereHas('perhiasan', function ($query) {
            $query->where('jenis', 'Perhiasan Muda');
        })->get();
        
        $stocks = $stocksRaw->map(function ($stock) {
            $stok_awal = $stock->jumlah;
            $keluar = $stock->penjualans->sum('jumlah_keluar');
            $sisa_stok = $stok_awal - $keluar;
            $real = $stock->real ?? 0; 
            $selisih = $real - $stok_awal;

            return [
                'id' => $stock->id,
                'item' => $stock->nama ?? '-',
                'stok_awal' => $stok_awal,
                'keluar' => $keluar,
                'sisa_stok' => $sisa_stok,
                'real' => $real,
                'selisih' => $selisih
            ];
        });

        $penjualansRaw = Penjualan::with('stock.produk')
            ->whereHas('stock.perhiasan', function ($query) {
                    $query->where('jenis', 'Perhiasan Muda');
                })
            ->latest()
            ->paginate(10);

        $penjualans = $penjualansRaw->map(function ($p) {
            $stock = $p->stock;

            return [
                'id' => $p->id,
                'item' => $stock->produk->jenis ?? '-', 
                'nama_barang' => $stock->nama ?? '-', 
                'kadar' => $stock->berat_kitir ?? 0,
                'berat' => $stock->berat_bersih ?? 0, 
                'harga' => ($stock->berat_bersih ?? 0) * $stock->pergram,
                'jumlah_keluar' => $p->jumlah_keluar,
                'kode' => $stock->kode ?? '-',
                'pergram_beli' => $stock->pergram,
                'harga_jual' => $p->harga_jual,
                'keterangan' => $p->keterangan ?? '-',
                'sales' => $p->sales,
            ];
        });

        $totalBerat = $stocksNormal->sum('berat_bersih');
        $totalHarga = $stocksNormal->sum('pergram') * $totalBerat; 
        $rataPerGram = $totalBerat > 0 ? round($totalHarga / $totalBerat, 2) : 0;

        return view('perhiasan-muda.penjualan', 
        [
            'stocks' => $stocks , 
            'stocksRaw' => $stocksRaw, 
            'stocksNormal' => $stocksNormal, 
            'penjualans' => $penjualans, 
            'penjualansRaw' => $penjualansRaw,
            'totalBerat' => $totalBerat,
            'totalHarga' => $totalHarga,
            'rataPerGram' => $rataPerGram,

        ]);
    }

    public function penjualanStore(Request $request)
    {
        try {
            $request->validate([
                'id_stock' => 'required|exists:stocks,id',
                'tanggal' => 'required|date',
                'keterangan' => 'nullable|string',
                'sales' => 'required|string',
                'jumlah_keluar' => 'required|numeric|min:0',
                'pergram' => 'required|numeric|min:0',
            ]);
            $stock = Stock::findOrFail($request->id_stock);
            $month = Carbon::parse($request->tanggal)->month;
            
            if ($request->jumlah_keluar > $stock->jumlah) {
                return back()->withErrors(['jumlah_keluar' => 'Jumlah keluar melebihi stok tersedia.']);
            }
            $stock->decrement('jumlah', $request->jumlah_keluar);

            Penjualan::create([
                'id_stock' => $request->id_stock,
                'id_bulan' => $month,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'sales' => $request->sales,
                'jumlah_keluar' => $request->jumlah_keluar,
                'harga_jual' => $request->pergram,
            ]);

            return redirect()->back()->with('success', 'Data penjualan berhasil ditambahkan');
        
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan penjualan: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
            ]);
        }
    }


    public function penjualanDestroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $stock = $penjualan->stock;

        // Restore stock jumlah
        $stock->jumlah += $penjualan->jumlah_keluar;
        $stock->save();

        $penjualan->delete();

        return redirect()->back()->with('success', 'Penjualan berhasil dihapus dan stok dikembalikan.');
    }


    public function penjualanUpdate(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sales' => 'required|string',
            'pergram' => 'required|numeric|min:0',
            'jumlah_keluar' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $stock = $penjualan->stock;

        $stock->jumlah += $penjualan->jumlah_keluar;
        if ($stock->jumlah < $request->jumlah_keluar) {
            return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang dimasukkan.');
        }

        $stock->jumlah -= $request->jumlah_keluar;
        $stock->save();

        $penjualan->update([
            'tanggal' => $request->tanggal,
            'sales' => $request->sales,
            'harga_jual' => $request->pergram,
            'jumlah_keluar' => $request->jumlah_keluar,
            'keterangan' => $request->keterangan,
            'id_bulan' => Carbon::parse($request->tanggal)->month,
        ]);

        return redirect()->back()->with('success', 'Data penjualan berhasil diperbarui.');
    }


    # pembelian
    public function pembelianGet() {
        $pembeliansRaw = Pembelian::with('perhiasan', 'produk', 'history')->whereHas('perhiasan', function ($query) {
            $query->where('jenis', 'Perhiasan Muda');
        })->paginate(10); 
        $produks = Product::all();
        

        $pembelians = $pembeliansRaw->map(function ($item) {

            return [
                'id' => $item->id,
                'perhiasan' => $item->produk->jenis ?? '-',
                'nama_barang' => $item->nama_barang,
                'kadar' => $item->kadar,
                'berat' => $item->berat,
                'harga' => $item->berat * $item->pergram_beli,
                'kode' => $item->kode,
                'harga_per_gram_beli' => $item->pergram_beli,
                'harga_per_gram_jual' => $item->pergram_jual,
                'keterangan' => $item->keterangan ?? '-',
                'sales' => $item->sales,
            ];
        });

        $totalBerat = $pembelians->sum('berat');
        $totalHarga = $pembelians->sum('harga');
        $rataHargaPerGram = $totalBerat > 0 ? ($totalHarga / $totalBerat) : 0;
        return view('perhiasan-muda.pembelian',  [
            'items' => $pembeliansRaw, 
            'pembelians' => $pembelians,
            'totalBerat' => $totalBerat,
            'totalHarga' => $totalHarga,
            'rataHargaPerGram' => $rataHargaPerGram,
            'produks' => $produks,
            ]
        );
    }
    public function pembelianStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode' => 'required|integer',
                'tanggal'=> 'required|date',
                'nama_barang' => 'required|string',
                'kadar' => 'required|numeric',
                'berat' => 'required|numeric',
                'pergram_beli' => 'required|numeric',
                'pergram_jual' => 'required|numeric',
                'sales' => 'required|string',
                'keterangan' => 'nullable|string',
                'id_perhiasan' => 'required|exists:perhiasans,id',
                'id_produk' => 'required|exists:products,id',
                'id_bulan' => 'required|exists:histories,id',
            ]);

            // Create pembelian
            Pembelian::create($validated);

            return redirect()->back()->with('success', 'Data pembelian berhasil ditambahkan');
        
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pembelian: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
            ]);
        }
    }

    public function pembelianUpdate(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        $request->validate([
            'kode' => 'required',
            'nama_barang' => 'required',
            'tanggal'=> 'required|date',
            'kadar' => 'required|numeric',
            'berat' => 'required|numeric',
            'pergram_beli' => 'required|numeric',
            'pergram_jual' => 'required|numeric',
            'sales' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $pembelian->update($request->all());

        return redirect()->back()->with('success', 'Data pembelian berhasil diperbarui');
    }
    public function pembelianDestroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->delete();

        return redirect()->back()->with('success', 'Data pembelian berhasil dihapus');
    }

    #ringkasan
    public function ringkasan() {
        $penjualans = Penjualan::with('stock.produk')
            ->whereHas('stock.perhiasan', fn($q) => $q->where('jenis', 'Perhiasan Muda'))
            ->get();
        $grouped = $penjualans->groupBy(function ($p) {
            return $p->stock->produk->jenis ?? 'Unknown';
        });

        $summary = $grouped->map(function ($group) {
            $totalQty = $group->sum('jumlah_keluar');
            $totalBerat = $group->sum(function ($p) {
                return ($p->stock->berat_bersih) * $p->jumlah_keluar;
            });
            $totalHarga = $group->sum(function ($p) {
                $berat = ($p->stock->berat_bersih) * $p->jumlah_keluar;
                return $berat * $p->stock->pergram;
            });
            return [
                'jenis' => $group->first()->stock->produk->jenis ?? 'Unknown',
                'qty' => $totalQty,
                'berat' => $totalBerat,
                'harga' => $totalHarga,
                'harga_per_gram' => $totalBerat > 0 ? $totalHarga / $totalBerat : 0
            ];
        })->values();
        $totalBerat = $penjualans->sum(function ($p) {
            return ($p->stock->berat_bersih ?? 0) * $p->jumlah_keluar;
        });
        $totalHarga = $penjualans->sum(function ($p) {
            $berat = ($p->stock->berat_bersih ?? 0) * $p->jumlah_keluar;
            return $berat * $p->stock->pergram;
        });
        $rataHargaPerGram = $totalBerat > 0 ? $totalHarga / $totalBerat : 0;

        $pembelianGroup = Pembelian::selectRaw('id_bulan, SUM(pergram_beli * berat) as total_pembelian')
            ->groupBy('id_bulan')
            ->get()
            ->keyBy('id_bulan');

        $penjualanGroup = Penjualan::selectRaw('id_bulan, SUM(harga_jual) as total_penjualan')
            ->groupBy('id_bulan')
            ->get()
            ->keyBy('id_bulan');

        $labaBersih = [];

        $allBulanIds = $pembelianGroup->keys()->merge($penjualanGroup->keys())->unique();

        foreach ($allBulanIds as $id_bulan) {
            $pembelian = $pembelianGroup[$id_bulan]->total_pembelian ?? 0;
            $penjualan = $penjualanGroup[$id_bulan]->total_penjualan ?? 0;
            $keuntungan = $penjualan - $pembelian;

            $labaBersih[] = [
                'pembelian' => round($pembelian, 2),
                'penjualan' => round($penjualan, 2),
                'keuntungan' => round($keuntungan, 2),
            ];
        }

        $pengeluarans = Pengeluaran::latest()->paginate(10);

        $totalBerat = Pembelian::sum('berat');
        $hargaPerGram = Pembelian::sum('pergram');
        $totalHarga = $totalBerat * $hargaPerGram;
        $totalPengeluaran = Pengeluaran::sum('nilai');

        $data = [
            [
                'jenis' => 'Pembelian',
                'berat' => $totalBerat,
                'jumlah' => $totalHarga,
                'harga_per_gram' => $hargaPerGram,
            ],
            [
                'jenis' => 'Pengeluaran',
                'berat' => null,
                'jumlah' => $totalPengeluaran,
                'harga_per_gram' => null,
            ]
        ];

        $penjualanLain = Penjualan_lain::latest()->paginate(10);
        $pricelists = Pricelists::all();

        $totalPembelian = Pembelian::selectRaw('SUM(pergram_beli * berat) as total')->value('total') ?? 0;

        $totalPenjualan = Penjualan::sum('harga_jual') ?? 0;

        $saldoAwal = 120000000;
        $saldoAkhir = $totalPembelian - $totalPenjualan;
        return view('perhiasan-muda.ringkasan', [
            'summary' => $summary,
            'penjualans' => $penjualans,
            'grouped' => $grouped,
            'totalBerat' => $totalBerat,
            'totalHarga' => $totalHarga,
            'rataHargaPerGram' => $rataHargaPerGram,
            'labaBersih' => $labaBersih,
            'pengeluarans' => $pengeluarans,
            'totalPengeluaran' => $data,
            'penjualanLain' => $penjualanLain,
            'pricelists' => $pricelists,
            'saldoAwal' => $saldoAwal,
            'saldoAkhir' => $saldoAkhir,

        ]);
    }

    public function ringkasanPengeluaranStore(Request $request) {
        $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        Pengeluaran::create([
            'nama' => $request->nama_pengeluaran,
            'nilai' => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    public function ringkasanPengeluaranUpdate(Request $request, $id) {
        $pengeluaran = Pengeluaran::findOrFail($id);

        $request->validate([
            'namaBarang' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0',
        ]);

        $pengeluaran->update([
            'nama' => $request->namaBarang,
            'nilai' => $request->nilai,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil diperbarui');
    }

    public function ringkasanPengeluaranDestroy($id) {
        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->delete();

        return redirect()->back()->with('success', 'Pengeluaran berhasil dihapus');
    }

    public function ringkasanPenjualanLainStore(Request $request) {
        $request->validate([
            'jenis_penjualan' => 'required|string|max:255',
            'berat' => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Penjualan_lain::create($request->all());

        return redirect()->back()->with('success', 'Penjualan lain berhasil ditambahkan');
    }

    public function ringkasanPenjualanLainDestroy($id) {
        $penjualanLain = Penjualan_lain::findOrFail($id);
        $penjualanLain->delete();

        return redirect()->back()->with('success', 'Penjualan lain berhasil dihapus');
    }

    public function ringkasanPricelistStore(Request $request) {
        $request->validate([
            'kadar' => 'required|numeric',
            'harga_min' => 'required|numeric|min:0',
            'harga_max' => 'required|numeric|min:0',
        ]);

        Pricelists::create($request->all());

        return redirect()->back()->with('success', 'Pricelist berhasil ditambahkan');
    }

    public function ringkasanPricelistDestroy($id) {
        $pricelist = Pricelists::findOrFail($id);
        $pricelist->delete();

        return redirect()->back()->with('success', 'Pricelist berhasil dihapus');
    }

    #gesek
    public function gesek() {
        $banks = ['BNI', 'BRI', 'BCA', 'Mandiri'];
        $perBankData = [];
        $bankSums = [];

        $saldoAwal = 0;
        $saldoAkhir = 0;

        foreach ($banks as $bank) {
            $perBankData[$bank] = Gesek::where('nama_bank', $bank)
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], strtolower($bank)); 
            $bankSums[$bank] = [
                'total_masuk' => Gesek::where('nama_bank', $bank)->sum('masuk'),
                'total_keluar' => Gesek::where('nama_bank', $bank)->sum('keluar'),
            ];
            $saldoAwal += $bankSums[$bank]['total_masuk'];
            $saldoAkhir += ($bankSums[$bank]['total_masuk'] - $bankSums[$bank]['total_keluar']);
        }
        return view('perhiasan-muda.gesek', compact('perBankData', 'bankSums', 'saldoAwal', 'saldoAkhir'));
    }

    public function gesekStore(Request $request)
    {
        $validated = $request->validate([
            'id_perhiasan' => 'required|exists:perhiasans,id',
            'nama_bank' => 'required|string',
            'nama' => 'required|string',
            'masuk' => 'required|integer|min:0',
            'keluar' => 'required|integer|min:0',
        ]);

        Gesek::create($validated);

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function gesekDestroy($id)
    {
        $gesek = Gesek::findOrFail($id);
        $gesek->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    #penjualan harian
    public function penjualanHarian($id) {
        $produks = Product::all();
        $selectedProduct = Product::findOrFail($id);

        // 1. Get the Perhiasan Muda
        $perhiasan = Perhiasan::where('jenis', 'Perhiasan Muda')->first();
        if (!$perhiasan) {
            return abort(404, 'Perhiasan Muda tidak ditemukan.');
        }
        $perhiasanId = $perhiasan->id;

        // 2. Query Stocks & Penjualans
        $stocks = Stock::with(['produk', 'perhiasan'])
            ->where('id_produk', $id)
            ->where('id_perhiasan', $perhiasanId)
            ->paginate(10)
            ->withQueryString();

        $penjualans = Penjualan::with(['stock.produk', 'stock.perhiasan'])
            ->whereHas('stock', function ($q) use ($id, $perhiasanId) {
                $q->where('id_produk', $id)
                ->where('id_perhiasan', $perhiasanId);
            })
            ->paginate(10)
            ->withQueryString();

        // 3. Stock Awal
        $stockAwalQty = Stock::where('id_produk', $id)
            ->where('id_perhiasan', $perhiasanId)
            ->sum('jumlah');

        $beratStockAwal = Stock::where('id_produk', $id)
            ->where('id_perhiasan', $perhiasanId)
            ->sum('berat_bersih') * $stockAwalQty;

        // 4. Tambahan from Pembelian
        $tambahanQty = Pembelian::where('id_produk', $id)
            ->where('id_perhiasan', $perhiasanId)
            ->count(); // jumlah pembelian entries

        $tambahanBerat = Pembelian::where('id_produk', $id)
            ->where('id_perhiasan', $perhiasanId)
            ->sum('berat') * $tambahanQty;

        // 5. Rusak from Stock (keterangan = 'rusak')
        $rusakQty = Stock::where('id_produk', $id)
            ->where('id_perhiasan', $perhiasanId)
            ->sum('rusak');

        $rusakBerat = Stock::where('id_produk', $id)
            ->where('id_perhiasan', $perhiasanId)
            ->where('rusak', '>', 0)
            ->sum('berat_bersih') * $rusakQty;

        // 6. Terjual from Penjualan
        $terjualRecords = Penjualan::whereHas('stock', function ($q) use ($id, $perhiasanId) {
                $q->where('id_produk', $id)
                ->where('id_perhiasan', $perhiasanId);
            })
            ->get();

        $terjual = $terjualRecords->sum('jumlah_keluar');
        $terjualBerat = $terjualRecords->sum(function ($penjualan) {
            return $penjualan->jumlah_keluar * optional($penjualan->stock)->berat_bersih ?? 0;
        });

        // 7. Sisa Stock & Berat
        $sisaStock = $stockAwalQty + $tambahanQty - $rusakQty - $terjual;
        $sisaBerat = $beratStockAwal + $tambahanBerat - $rusakBerat - $terjualBerat;

        return view('perhiasan-muda.penjualan_harian', [
            'produks' => $produks,
            'selectedProduct' => $selectedProduct,
            'penjualans' => $penjualans,
            'stocks' => $stocks,

            'stockAwal' => $stockAwalQty,
            'beratStockAwal' => $beratStockAwal,

            'tambahanQty' => $tambahanQty,
            'tambahanBerat' => $tambahanBerat,

            'rusak' => $rusakQty,
            'rusakBerat' => $rusakBerat,

            'terjual' => $terjual,
            'terjualBerat' => $terjualBerat,

            'sisaStock' => $sisaStock,
            'sisaBerat' => $sisaBerat,
        ]);
    }
}
