<x-app-layout class="bg-perhiasan-muda">
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Perhiasan Muda</h2>
    </x-slot>

    <x-perhiasan-muda-submenu/>

    <div class= "flex flex-col gap-9 my-10" >
        <div x-data="{ open: false, selected: '{{ $selectedProduct->id ? $produks->firstWhere('id', $selectedProduct->id)->jenis : 'Pilih Jenis' }}' }" class="w-full mb-4">
            <button @click="open = !open"
                class="w-full bg-primary-300 border-primary-800 border-2 text-primary-800 font-semibold px-4 py-2 text-lg rounded-xl text-center">
                <span x-text="selected"></span>
                <span class="float-right transform" :class="{ 'rotate-180': open }">v</span>
            </button>

            <ul x-show="open" @click.outside="open = false"
                class="bg-perhiasan-muda rounded-xl my-2 transition-all duration-300 space-y-1 ">
                @foreach($produks as $p)
                    <li>
                        <button onclick="window.location.href='{{ route('perhiasan.muda.penjualanHarian',  ['id' => $p->id ]) }}'"
                            class="w-full bg-white my-2 block px-4 py-2 text-lg text-center text-primary-800 hover:bg-primary-300 border-primary-800 border-2 rounded-xl"
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
                        <tr class="text-left border-b border-gray-200">
                            <th class="py-2 px-4">No</th>
                            <th class="py-2 px-4">Item</th>
                            <th class="py-2 px-4">Nama Barang</th>
                            <th class="py-2 px-4">Kedar</th>
                            <th class="py-2 px-4">Berat</th>
                            <th class="py-2 px-4">Harga</th>
                            <th class="py-2 px-4">Jumlah</th>
                            <th class="py-2 px-4">Kode</th>
                            <th class="py-2 px-4">Per Gram Beli</th>
                            <th class="py-2 px-4">Per Gram Jual</th>
                            <th class="py-2 px-4">Keterangan</th>
                            <th class="py-2 px-4">Sales</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($penjualans ?? [] as $item)
                            <tr>
                                <td class="py-2 px-4">{{ ($penjualans->currentPage() - 1) * $penjualans->perPage() + $loop->iteration }}</td>
                                <td class="py-2 px-4">{{ $item->stock->produk->jenis ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $item->stock->nama ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $item->stock->perhiasan->kadar ?? '-' }}%</td>
                                <td class="py-2 px-4">{{ number_format($item->stock->berat_bersih ?? 0, 3) }} Gr</td>
                                <td class="py-2 px-4">Rp. {{ number_format($item->harga_jual * $item->stock->berat_bersih ?? 0, 0, ',', '.') }}</td>
                                <td class="py-2 px-4">{{ $item->jumlah_keluar ?? 0 }}</td>
                                <td class="py-2 px-4">{{ $item->stock->kode ?? '-' }}</td>
                                <td class="py-2 px-4">
                                    Rp. {{ number_format($item->stock->pergram ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-2 px-4">
                                    Rp. {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-2 px-4">{{ $item->keterangan ?? '-' }}</td>
                                <td class="py-2 px-4">{{ $item->sales ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-gray-500 py-4">Data Unavailable</td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if(isset($penjualans) && $penjualans->count() > 0)
                    <tfoot>
                        <tr class="bg-yellow-100 font-semibold">
                            <td colspan="4" class="py-2 px-4 italic">Jumlah</td>
                            <td class="py-2 px-4 text-purple-600">{{ number_format($penjualans->sum('stock.berat_bersih') ?? 0, 3) }} Gr</td>
                            <td class="py-2 px-4 text-purple-600">Rp. {{ number_format($penjualans->sum(fn($item) => $item->harga_jual * $item->stock->berat_bersih) ?? 0, 0, ',', '.') }}</td>
                            <td colspan="2"></td>

                            <td colspan="1" class="py-2 px-4 text-purple-600">
                                Rata / Gram: Rp. {{ number_format($penjualans->avg('stock.pergram') ?? 0, 0, ',', '.') }}
                            </td>
                            <td colspan="1" class="py-2 px-4 text-purple-600">
                                Rata / Gram: Rp. {{ number_format($penjualans->avg('harga_jual') ?? 0, 0, ',', '.') }}
                            </td>
                            <td colspan="2"></td>
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
                            <tr class="text-left border-b border-gray-200">
                                <th class="py-2 px-4">keterangan</th>
                                <th class="py-2 px-4">Qyt</th>
                                <th class="py-2 px-4">Berat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($stocks ?? [] as $item)
                                <tr>
                                    <td class="py-2 px-4">{{ $item['nama'] }}</td>
                                    <td class="py-2 px-4">{{ $item['jumlah'] ?? '-' }}</td>
                                    <td class="py-2 px-4">{{ number_format($item['berat_bersih'] ?? 0, 3) }} Gr</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 py-4">Data Unavailable</td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if(isset($stocks) && $stocks->count() > 0)
                        <tfoot>
                            <tr class="bg-yellow-100 font-semibold">
                                <td class="py-2 px-4 italic">Jumlah</td>
                                <td class="py-2 px-4 text-purple-600">{{ $stocks->sum('jumlah') ?? 0  }}</td>
                                <td class="py-2 px-4 text-purple-600">{{ number_format($stocks->sum('berat_bersih') ?? 0, 3) }} Gr</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>

                    {{-- Pagination --}}
                    @if(isset($stocks) && $stocks->count() > 0)
                    <div class="mt-4 flex justify-center">
                        {{ $stocks->links('pagination::tailwind') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>