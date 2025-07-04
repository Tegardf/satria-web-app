<?php

namespace App\Http\Controllers;

use App\Models\Restock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RestockProdukController extends Controller
{
    public function index()
    {
        $data = Restock::with(['produk', 'perhiasan'])->get();

        $grouped = $data->groupBy(function ($item) {
            return  $item->produk->jenis . " " . $item->perhiasan->jenis;
        });
        // dd($groupe);
        return view('restock-produk', compact('grouped'));
    }

    public function toggleStatus(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:restocks,id',
                'status' => 'required|boolean',
            ]);
            $restock = Restock::findOrFail($request->id);
            $restock->status = $request->status;
            $restock->save();

            return response()->json(['message' => 'Status updated']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);

        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'model' => 'required|string',
            'berat' => 'required|numeric',
            'ukuran' => 'required|string',
            'kadar' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'id_perhiasan' => 'required|exists:perhiasans,id',
            'id_produk' => 'required|exists:products,id',
        ]);

        Restock::create([
            'model' => $request->model,
            'berat' => $request->berat,
            'ukuran' => $request->ukuran,
            'kadar' => $request->kadar,
            'jumlah' => $request->jumlah,
            'status' => false,
            'id_perhiasan' => $request->id_perhiasan, 
            'id_produk' => $request->id_produk, 
        ]);

        return redirect()->back()->with('success', 'Item added.');
    }

    public function destroy($id)
    {
        Restock::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item deleted.');
    }
}
