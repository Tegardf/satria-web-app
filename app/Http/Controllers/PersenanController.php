<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PersenanController extends Controller
{
    public function index(Request $request)
    {
        $monthTua = $request->input('idTua');
        $monthMuda = $request->input('idMuda');

        $persenanTua = $this->getPersenanByTypeAndBulan('Perhiasan Tua', $monthTua);
        $persenanMuda = $this->getPersenanByTypeAndBulan('Perhiasan Muda', $monthMuda);

        $persenanTua = $this->remapPersenan($persenanTua);
        $persenanMuda = $this->remapPersenan($persenanMuda);

        $listBulan = History::all();

        $totalPenjualanMuda = collect($persenanMuda)->sum('penjualan.harga');
        $totalPembelianMuda = collect($persenanMuda)->sum('pembelian.harga');
        $totalPenjualanTua = collect($persenanTua)->sum('penjualan.harga');
        $totalPembelianTua = collect($persenanTua)->sum('pembelian.harga');
        $totalPersenanMuda = $totalPenjualanMuda + $totalPembelianMuda;
        $totalPersenanTua = $totalPenjualanTua + $totalPembelianTua;

        return view('persenan', 
        [
            'perhiasanTua' => $persenanTua, 
            'perhiasanMuda'=>$persenanMuda, 
            'histories' => $listBulan,
            'totalpersenanMuda' => $totalPersenanMuda,
            'totalpersenanTua' => $totalPersenanTua,
        ]);
    }

    private function remapPersenan(array $data)
    {
        $result = [];

        $tanggalList = collect($data['penjualan'])->pluck('tanggal')
            ->merge(collect($data['pembelian'])->pluck('tanggal'))
            ->unique()
            ->sort()
            ->values();

        foreach ($tanggalList as $tanggal) {
            $penjualan = collect($data['penjualan'])->firstWhere('tanggal', $tanggal);
            $pembelian = collect($data['pembelian'])->firstWhere('tanggal', $tanggal);

            $result[] = [
                'tanggal' => $tanggal,
                'penjualan' => [
                    'berat' => $penjualan['berat'] ?? null,
                    'harga' => $penjualan['harga'] ?? null,
                ],
                'pembelian' => [
                    'berat' => $pembelian['berat'] ?? null,
                    'harga' => $pembelian['harga'] ?? null,
                ],
            ];
        }

        return $result;
    }
    private function getPersenanByTypeAndBulan(string $type, ?int $bulan)
    {
        $penjualans = Penjualan::with(['stock.produk'])
            ->where('id_bulan', $bulan)
            ->whereHas('stock.perhiasan', fn($q) => $q->where('jenis', $type))
            ->get()
            ->map(fn($item) => [
                'tanggal' => $item->tanggal,
                'berat' => $item->stock->berat_bersih,
                'harga' => $item->harga_jual * $item->stock->berat_bersih,
            ]);
        $pembelians = Pembelian::with('perhiasan')
            ->where('id_bulan', $bulan)
            ->whereHas('perhiasan', fn($q) => $q->where('jenis', $type))
            ->get()
            ->map(fn($item) => [
                'tanggal' => $item->tanggal,
                'berat' => $item->berat,
                'harga' => $item->berat * $item->pergram_beli,
            ]);
        $penjualans->sortBy('tanggal')->values();
        $pembelians->sortBy('tanggal')->values();


        return [
            'penjualan' => $penjualans,
            'pembelian' => $pembelians
        ];
    }
}
