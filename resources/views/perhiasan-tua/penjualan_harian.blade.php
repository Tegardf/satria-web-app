<x-app-layout class="bg-perhiasan-tua">
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Perhiasan Tua</h2>
    </x-slot>

    <x-perhiasan-tua-submenu/>

    <div class= "flex flex-col gap-9 my-10" >
        <div x-data="{ open: false, selected: '{{ $selectedProduct->id ? $produks->firstWhere('id', $selectedProduct->id)->jenis : 'Pilih Jenis' }}' }" class="w-full mb-4">
            <button @click="open = !open"
                class="w-full bg-primary-300 border-primary-800 border-2 text-primary-800 font-semibold px-4 py-2 text-lg rounded-xl text-center">
                <span x-text="selected"></span>
                <span class="float-right transform" :class="{ 'rotate-180': open }">v</span>
            </button>

            <ul x-show="open" @click.outside="open = false"
                class="bg-perhiasan-tua rounded-xl my-2 transition-all duration-300 space-y-1 ">
                @foreach($produks as $p)
                    <li>
                        <button onclick="window.location.href='{{ route('perhiasan.tua.penjualanHarian',  ['id' => $p->id ]) }}'"
                            class="w-full bg-white my-2 block px-4 py-2 text-lg text-center text-primary-800 hover:bg-primary-300 border-primary-800 border-2 rounded-xl {{ request()->route('id') == $p->id ? 'hidden' : '' }}"
                            @click="selected = '{{ $p->Jenis }}'; open = false;">
                            {{ $p->jenis }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class=" bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-purple-800 mb-4">Penjualan {{$selectedProduct->jenis}}</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-sm text-gray-800">
                    <thead>
                        <tr class="text-left bg-gray-200">
                            <th class="py-2 px-4 border">No</th>
                            <th class="py-2 px-4 border">Item</th>
                            <th class="py-2 px-4 border">Nama Barang</th>
                            <th class="py-2 px-4 border">Kadar</th>
                            <th class="py-2 px-4 border">Berat</th>
                            <th class="py-2 px-4 border">Harga</th>
                            <th class="py-2 px-4 border">Jumlah</th>
                            <th class="py-2 px-4 border">Kode</th>
                            <th class="py-2 px-4 border">Per Gram Beli</th>
                            <th class="py-2 px-4 border">Per Gram Jual</th>
                            <th class="py-2 px-4 border">Keterangan</th>
                            <th class="py-2 px-4 border">Sales</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($penjualans ?? [] as $item)
                            <tr>
                                <td class="py-2 px-4 border">{{ ($penjualans->currentPage() - 1) * $penjualans->perPage() + $loop->iteration }}</td>
                                <td class="py-2 px-4 border">{{ $item->stock->produk->jenis ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $item->stock->nama ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $item->stock->perhiasan->kadar ?? '-' }}%</td>
                                <td class="py-2 px-4 border">{{ number_format($item->stock->berat_bersih ?? 0, 3) }} Gr</td>
                                <td class="py-2 px-4 border">Rp. {{ number_format($item->harga_jual * $item->stock->berat_bersih ?? 0, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">{{ $item->jumlah_keluar ?? 0 }}</td>
                                <td class="py-2 px-4 border">{{ $item->stock->kode ?? '-' }}</td>
                                <td class="py-2 px-4 border">
                                    Rp. {{ number_format($item->stock->pergram ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-2 px-4 border">
                                    Rp. {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-2 px-4 border">{{ $item->keterangan ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $item->sales ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-gray-500 py-4 border">Data Unavailable</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(isset($penjualans) && $penjualans->count() > 0)
                    <tfoot>
                        <tr class="bg-yellow-100 font-semibold">
                            <td colspan="4" class="py-2 px-4 italic border">Jumlah</td>
                            <td class="py-2 px-4 text-purple-600 border">{{ number_format($penjualans->sum('stock.berat_bersih') ?? 0, 3) }} Gr</td>
                            <td class="py-2 px-4 text-purple-600 border">Rp. {{ number_format($penjualans->sum(fn($item) => $item->harga_jual * $item->stock->berat_bersih) ?? 0, 0, ',', '.') }}</td>
                            <td colspan="2" class="border"></td>
                            <td colspan="1" class="py-2 px-4 text-purple-600 border">
                                Rata / Gram: Rp. {{ number_format($penjualans->avg('stock.pergram') ?? 0, 0, ',', '.') }}
                            </td>
                            <td colspan="1" class="py-2 px-4 text-purple-600 border">
                                Rata / Gram: Rp. {{ number_format($penjualans->avg('harga_jual') ?? 0, 0, ',', '.') }}
                            </td>
                            <td colspan="2" class="border"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>

                {{-- Pagination --}}
                @if(isset($penjualans) && $penjualans->count() > 0)
                <div class="mt-4 flex justify-center">
                    {{ $penjualans->links('pagination::tailwind') }}
                </div>
                @endif
            </div>
        </div>
        <div class="w-full grid grid-cols-3 gap-10">
            <div class="col-span-1 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">stock {{$selectedProduct->jenis}}</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-gray-800">
                        <thead>
                            <tr class="text-center bg-gray-200">
                                <th class="py-2 px-4 border">keterangan</th>
                                <th class="py-2 px-4 border">Qyt</th>
                                <th class="py-2 px-4 border">Berat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="text-center py-2 border">Stock Awal</td>
                                <td class="text-center border py-2">{{ $stockAwal }}</td>
                                <td class="text-center border py-2">{{ number_format($beratStockAwal, 3, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center py-2 border">Tambahan</td>
                                <td class="text-center border py-2">{{ $tambahanQty }}</td>
                                <td class="text-center border py-2">{{ number_format($tambahanBerat, 3, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center py-2 border">Rusak</td>
                                <td class="text-center border py-2">{{ $rusak }}</td>
                                <td class="text-center border py-2">{{ number_format($rusakBerat, 3, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center py-2 border">Terjual</td>
                                <td class="text-center border py-2">{{ $terjual }}</td>
                                <td class="text-center border py-2">{{ number_format($terjualBerat, 3, ',', '.') }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class=" text-center bg-yellow-100 font-semibold">
                                <td class="py-2 px-4  italic border">Jumlah</td>
                                <td class="py-2 px-4 text-purple-600 border">{{ $sisaStock ?? 0  }}</td>
                                <td class="py-2 px-4 text-purple-600 border">{{ number_format($sisaBerat, 3, ',', '.') }} Gr</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>