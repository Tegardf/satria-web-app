<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Penjualan_lain;
use App\Models\Pricelists;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->get('mode', 'monthly');
        $pricelists = Pricelists::all();
        $labaPembelian = Pembelian::all()->sum(function ($pembelian) {
            return ($pembelian->pergram_jual - $pembelian->pergram_beli) * $pembelian->berat;
        });
        $labaPenjualan = Penjualan::with('stock')->get()->sum(function ($penjualan) {
            $berat = $penjualan->stock->berat_bersih ?? 0;
            return ($penjualan->harga_jual - $penjualan->stock->pergram) * $berat;
        });
        $totalPengeluaran = Pengeluaran::sum('nilai');
        $pemasukanTotal = $labaPenjualan + $labaPembelian;
        $keuntunganTotal = $pemasukanTotal - $totalPengeluaran;
        $stockPersediaan = Stock::all()->sum(function ($s) {
            return $s->berat_bersih * $s->jumlah;
        });

        $pembelianPersediaan = Pembelian::all()->sum(function ($p) {
            return $p->berat * 1; 
        });

        $persediaan = $stockPersediaan + $pembelianPersediaan;

        $label = [];
        $valuePengeluaran = [];
        $valuePemasukan = [];

        if ($mode === 'monthly') {

            for ($month = 1; $month <= 12; $month++) {
                $start = Carbon::create(null, $month, 1)->startOfMonth();
                $end = $start->copy()->endOfMonth();
                $label[] = $start->format('F');

                $pengeluaran = Pengeluaran::whereBetween('created_at', [$start, $end])->sum('nilai');

                $pemasukan = Penjualan::with('stock')
                    ->whereBetween('tanggal', [$start, $end])
                    ->get()
                    ->sum(function ($p) {
                        return ($p->harga_jual) * ($p->stock->berat_bersih ?? 0);
                    });

                $pemasukan += Penjualan_lain::whereBetween('created_at', [$start, $end])->sum('harga');

                $valuePengeluaran[] = $pengeluaran;
                $valuePemasukan[] = $pemasukan;
            }

        } elseif ($mode === 'weekly') {

            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();

            $weeks = [];
            $current = $monthStart->copy();

            while ($current < $monthEnd) {
                $start = $current->copy()->startOfWeek(Carbon::MONDAY);
                $end = $start->copy()->endOfWeek(Carbon::SUNDAY)->min($monthEnd);
                $weeks[] = ['start' => $start, 'end' => $end];
                $current = $end->copy()->addDay();
            }

            foreach ($weeks as $i => $week) {
                $label[] = 'Week ' . ($i + 1);

                $pengeluaran = Pengeluaran::whereBetween('created_at', [$week['start'], $week['end']])->sum('nilai');

                $pemasukan = Penjualan::with('stock')
                    ->whereBetween('tanggal', [$week['start'], $week['end']])
                    ->get()
                    ->sum(function ($p) {
                        return ($p->harga_jual) * ($p->stock->berat_bersih ?? 0);
                    });

                $pemasukan += Penjualan_lain::whereBetween('created_at', [$week['start'], $week['end']])->sum('harga');

                $valuePengeluaran[] = $pengeluaran;
                $valuePemasukan[] = $pemasukan;
            }
        }
        $kategoriList = Product::distinct()->pluck('jenis')->sort()->values();
        $penjualanGrouped = Penjualan::with('stock.produk')->get()
            ->groupBy(function ($item) {
                return $item->stock->produk->jenis ?? 'Unknown';
            });
        $penjualanValue = $kategoriList->map(function ($jenis) use ($penjualanGrouped) {
            return $penjualanGrouped->get($jenis, collect())->sum('jumlah_keluar');
        });

        $latestPenjualan = Penjualan::with('stock.produk')
            ->latest()
            ->take(5) 
            ->get();

        $transaksi = $latestPenjualan->map(function ($p) {
            $produk = $p->stock->produk ?? null;
            $stock = $p->stock ?? null;

            return [
                'item'    => $produk->jenis ?? 'Unknown',
                'persen'  => $stock->berat_kitir ?? '-', 
                'berat'   => $stock->berat_bersih ?? 0,
                'harga'   => $p->harga_jual ?? 0,
                'kode'    => $stock->kode ?? '-',
                'pergram' => $stock->pergram ?? 0,
                'ket'     => $p->keterangan ?? 'Terjual',
            ];
        });
        return view('dashboard', [
            'keuntungan' => $keuntunganTotal,
            'pemasukan' => $pemasukanTotal,
            'persediaan' => $persediaan,
            'chartDays' => $label,
            'pengeluaran' => $valuePengeluaran,
            'pemasukanBar' => $valuePemasukan,
            'penjualanLabel' => $kategoriList,
            'penjualanValue' => $penjualanValue,
            'transaksi' => $transaksi,
            'pricelists' => $pricelists,
        ]);
    }
}
