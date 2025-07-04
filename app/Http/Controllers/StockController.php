<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Stock;
use App\Models\Perhiasan;
use App\Models\Product;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $perhiasans = Perhiasan::all();
        $produks = Product::all();
        $selectedPerhiasan = $request->get('perhiasan_id');
        $selectedProduk = $request->get('produk_id');

        $stocks = Stock::with(['perhiasan', 'produk'])
            ->when($selectedPerhiasan, fn($q) => $q->where('id_perhiasan', $selectedPerhiasan))
            ->when($selectedProduk, fn($q) => $q->where('id_produk', $selectedProduk))
            ->orderByDesc('tanggal')
            ->paginate(10);

        return view('input-produk', compact('stocks', 'perhiasans', 'produks', 'selectedPerhiasan', 'selectedProduk'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_perhiasan' => 'required',
            'id_produk' => 'required',
            'kode' => 'required|string',
            'nama' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer',
            'berat_kotor' => 'required|numeric',
            'berat_bersih' => 'required|numeric',
            'berat_kitir' => 'required|numeric',
            'pergram' => 'required|integer',
            'real' => 'nullable|numeric',
        ]);

        Stock::create($data);

        return back()->with('success', 'Stock berhasil ditambahkan');
    }

    public function update(Request $request, Stock $stock)
    {
        $data = $request->validate([
            'kode' => 'required|string',
            'nama' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer',
            'berat_kotor' => 'required|numeric',
            'berat_bersih' => 'required|numeric',
            'berat_kitir' => 'required|numeric',
            'pergram' => 'required|integer',
            'real' => 'nullable|numeric',
        ]);

        $stock->update($data);

        return back()->with('success', 'Stock berhasil diupdate');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return back()->with('success', 'Stock berhasil dihapus');
    }
}
