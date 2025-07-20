<x-app-layout class="bg-perhiasan-muda">
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Perhiasan Tuda</h2>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-message" class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif
    <x-perhiasan-muda-submenu/>

    <div class= "flex flex-col gap-9 my-10" >
        <div class="flex flex-row gap-10">
            <!-- Card 1 -->
            <div class="flex w-full h-40 items-center bg-card-gradient-2 text-purple-900 p-4 rounded-xl shadow">
                <img src="{{ asset('penjualan-tua-ringkasan-1.svg') }}" alt="Stok Icon" class="absolute z-0 w-36 h-36">
                <div class="flex flex-1 h-full flex-col items-center justify-center gap-4 z-10">
                    <div class="text-3xl font-semibold">Saldo Awal</div>
                    <div class="text-4xl font-semibold">RP {{ number_format($saldoAwal, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="flex w-full h-40 items-center bg-card-gradient-3 text-purple-900 p-4 rounded-xl shadow">
                <div class="flex flex-1 h-full flex-col items-center justify-center gap-4 z-10 text-secondary-300">
                    <div class="text-3xl font-semibold">Saldo akhir</div>
                    <div class="text-4xl font-semibold">RP {{ number_format($saldoAkhir, 0, ',', '.') }}</div>
                </div>
                <img src="{{ asset('penjualan-tua-ringkasan-2.svg') }}" alt="Stok Icon" class="absolute z-0 w-36 h-36 right-10">
            </div>
        </div>
        <div class="w-full grid grid-cols-3 gap-10">
            <div class="col-span-2 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">Gabungan Penjualan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                        <thead>
                            <tr class="text-left bg-gray-200">
                                <th class="py-2 px-4 border">Qyt</th>
                                <th class="py-2 px-4 border">Jenis</th>
                                <th class="py-2 px-4 border">Berat</th>
                                <th class="py-2 px-4 border">Harga</th>
                                <th class="py-2 px-4 border">Harga /Gr</th>


                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($summary ?? [] as $item)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $item['qty'] ?? '-' }}</td>
                                    <td class="py-2 px-4 border">{{ $item['jenis'] ?? '-' }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($item['berat'] ?? '0', 3, ',', '.') }} Gr</td>
                                    <td class="py-2 px-4 border">Rp. {{ number_format($item['harga'] ?? '0',0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border">Rp. {{ number_format($item['harga_per_gram'] ?? '0',0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4">Data Unavailable</td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if(isset($summary) && $summary->count() > 0)
                        <tfoot>
                            <tr class="bg-yellow-100 font-semibold">
                                <td colspan="2" class="py-2 px-4 italic border">Jumlah</td>
                                <td class="py-2 px-4 text-purple-600 border">{{ number_format($summary->sum('berat') ?? 0, 3) }} Gr</td>
                                <td class="py-2 px-4 text-purple-600 border">Rp. {{ number_format($summary->sum('harga') ?? 0, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 text-purple-600 border">
                                    Rata / Gram: Rp. {{ number_format($summary->avg('harga_per_gram') ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>

                    {{-- Pagination --}}
                    @if(isset($items) && $items->count() > 0)
                    <div class="mt-4 flex justify-center">
                        {{ $items->links('pagination::tailwind') }}
                    </div>
                    @endif
                </div>
            </div>
            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="col-span-1 bg-white rounded-xl shadow-md p-6">
                        <h2 class="text-xl font-semibold text-purple-800 mb-4">Laba Bersih</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                                <thead>
                                    <tr class="text-left bg-gray-200">
                                        <th class="py-2 px-4 border">Pembelian</th>
                                        <th class="py-2 px-4 border">Penjualan</th>
                                        <th class="py-2 px-4 border">Keuntungan</th>

                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($labaBersih ?? [] as $item)
                                        <tr>
                                            <td class="py-2 px-4 border">Rp. {{ number_format($item['pembelian'] ?? 0, 0, ',', '.') }}</td>
                                            <td class="py-2 px-4 border">Rp. {{ number_format($item['penjualan'] ?? 0, 0, ',', '.') }}</td>
                                            <td class="py-2 px-4 border">Rp. {{ number_format($item['keuntungan'] ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-gray-500 py-4">Data Unavailable</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                @if(isset($labaBersih) && count($labaBersih) > 0)
                                <tfoot>
                                    <tr class="bg-yellow-100 font-semibold">
                                        <td class="py-2 px-4 text-purple-600 border">Rp. {{ number_format(collect($labaBersih)->sum('pembelian') ?? 0, 0,',','.') }}</td>
                                        <td class="py-2 px-4 text-purple-600 border">Rp. {{ number_format(collect($labaBersih)->sum('penjualan') ?? 0, 0,',','.') }}</td>
                                        <td class="py-2 px-4 text-purple-600 border">Rp. {{ number_format(collect($labaBersih)->sum('keuntungan') ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>

                            {{-- Pagination --}}
                            @if(isset($items) && $items->count() > 0)
                            <div class="mt-4 flex justify-center">
                                {{ $items->links('pagination::tailwind') }}
                            </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endauth
        </div>
        <div class="w-full grid grid-cols-2 gap-10">
            <div class="col-span-1 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">Rincian Pengeluaran</h2>
                <div class="text-right my-4">
                    <button onclick="document.getElementById('modal-pengeluaran-muda').classList.remove('hidden')" class="bg-secondary-700 text-white px-4 py-2 rounded hover:bg-secondary-800">
                        Tambah
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                        <thead>
                            <tr class="text-left bg-gray-200">
                                <th class="py-2 px-4 border">No</th>
                                <th class="py-2 px-4 border">Pengeluaran</th>
                                <th class="py-2 px-4 border">Nilai</th>
                                <th class="py-2 px-4 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($pengeluarans ?? [] as $item)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4 border">{{ $item['nama'] ?? '-' }}</td>
                                    <td class="py-2 px-4 border">Rp {{ number_format($item['nilai'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="p-2 flex flex-row gap-6 justify-center border">
                                        <button
                                            onclick="openEditModalRingkasanPengeluaran(this)"
                                            data-id="{{ $item['id'] }}"
                                            data-nama_barang="{{ $item['nama'] }}"
                                            data-nilai="{{ $item['nilai'] }}"
                                            class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </button>
                                        <form method="POST" action="{{ route('perhiasan.muda.ringkasan.pengeluaran.destroy', $item['id']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900"> <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 py-4 border">Data Unavailable</td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if(isset($pengeluarans) && $pengeluarans->count() > 0)
                        <tfoot>
                            <tr class="bg-yellow-100 font-semibold">
                                <td colspan="2" class="py-2 px-4 italic border">Jumlah</td>
                                <td class="py-2 px-4 text-purple-600 border">
                                    Rp. {{ number_format($pengeluarans->sum('nilai') ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-2 px-4 text-purple-600 border"></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>

                    {{-- Pagination --}}
                    @if(isset($pengeluarans) && $pengeluarans->count() > 0)
                    <div class="mt-4 flex justify-center">
                        {{ $pengeluarans->links('pagination::tailwind') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-span-1 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">Total Pengeluaran</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                        <thead>
                            <tr class="text-left bg-gray-200">
                                <th class="py-2 px-4 border">Jenis Pengeluaran</th>
                                <th class="py-2 px-4 border">Berat</th>
                                <th class="py-2 px-4 border">Jumlah</th>
                                <th class="py-2 px-4 border">Harga /Gr</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($totalPengeluaran ?? [] as $item)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $item['jenis'] ?? '-' }}</td>
                                    <td class="py-2 px-4 border">
                                        {{ isset($item['berat']) ? number_format($item['berat'], 3, ',', '.') . ' Gr' : '-' }}
                                    </td>
                                    <td class="py-2 px-4 border">
                                        {{ isset($item['jumlah']) ? 'Rp. ' . number_format($item['jumlah'], 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="py-2 px-4 border">
                                        {{ isset($item['harga_per_gram']) ? 'Rp. ' . number_format($item['harga_per_gram'], 0, ',', '.') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 py-4 border">Data Unavailable</td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if(isset($totalPengeluaran) && count($totalPengeluaran) > 0)
                        <tfoot>
                            <tr class="bg-yellow-100 font-semibold">
                                <td class="py-2 px-4 italic border">Jumlah</td>
                                <td class="py-2 px-4 text-purple-600 border">{{ number_format(collect($totalPengeluaran)->sum('berat') ?? 0, 3) }} Gr</td>
                                <td class="py-2 px-4 text-purple-600 border">Rp. {{ number_format(collect($totalPengeluaran)->sum('jumlah') ?? 0, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 text-purple-600 border">Rp. {{ number_format(collect($totalPengeluaran)->sum('harga_per_gram') ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="w-full grid grid-cols-3 gap-10">
            <div class="col-span-2 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">Penjualan Lain</h2>
                <div class="text-right my-4">
                    <button onclick="document.getElementById('modal-penjualanLain-muda').classList.remove('hidden')" class="bg-secondary-700 text-white px-4 py-2 rounded hover:bg-secondary-800">
                        Tambah
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                        <thead>
                            <tr class="text-left bg-gray-200">
                                <th class="py-2 px-4 border">No</th>
                                <th class="py-2 px-4 border">jenis Penjualan</th>
                                <th class="py-2 px-4 border">Berat</th>
                                <th class="py-2 px-4 border">Harga</th>
                                <th class="py-2 px-4 border">Keterangan</th>
                                <th class="py-2 px-4 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($penjualanLain ?? [] as $item)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4 border">{{ $item['jenis_penjualan'] ?? '-' }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($item['berat'] ?? 0, 3) }} Gr</td>
                                    <td class="py-2 px-4 border">Rp. {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border">{{ $item['keterangan'] ?? '-' }}</td>
                                    <td class="p-2 flex flex-row gap-6 justify-center border">
                                        <form method="POST" action="{{ route('perhiasan.muda.ringkasan.penjualanLain.destroy', $item['id']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900"> <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4 border">Data Unavailable</td>
                                </tr>
                            @endforelse
                        </tbody>

                        @if(isset($penjualanLain) && $penjualanLain->count() > 0)
                        <tfoot>
                            <tr class="bg-yellow-100 font-semibold">
                                <td colspan="2" class="py-2 px-4 italic border">Jumlah</td>
                                <td class="py-2 px-4 text-purple-600 border">{{ number_format($penjualanLain->sum('berat') ?? 0, 3) }} Gr</td>
                                <td colspan="3" class="py-2 px-4 text-purple-600 border">Rp. {{ number_format($penjualanLain->sum('harga') ?? 0, 0, ',', '.') }}</td>

                            </tr>
                        </tfoot>
                        @endif
                    </table>

                    {{-- Pagination --}}
                    @if(isset($penjualanLain) && $penjualanLain->count() > 0)
                    <div class="mt-4 flex justify-center">
                        {{ $penjualanLain->links('pagination::tailwind') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-span-1 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">Price list</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                        <thead>
                            <tr class="text-left bg-gray-200">
                                <th class="py-2 px-4 border">Kadar</th>
                                <th class="py-2 px-4 border">Max</th>
                                <th class="py-2 px-4 border">Min</th>
                                <th class="py-2 px-4 border"></th>

                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($pricelists ?? [] as $item)
                                <tr>
                                    <td class="py-2 px-4 border">{{ $item['kadar'] ?? '-' }}K</td>
                                    <td class="py-2 px-4 border">Rp. {{ number_format($item['harga_max'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border">Rp. {{ number_format($item['harga_min'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="p-2 flex flex-row gap-6 justify-center border">
                                        <form method="POST" action="{{ route('perhiasan.muda.ringkasan.pricelist.destroy', $item['id']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900"> <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 py-4 border">Data Unavailable</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                <div class="text-center my-4">
                    <button onclick="document.getElementById('modal-pricelist-muda').classList.remove('hidden')" class="bg-secondary-700 text-white px-4 py-2 rounded hover:bg-secondary-800">
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-pricelist-muda" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white w-full max-w-3xl rounded-lg p-6 shadow-lg relative">
            <button onclick="document.getElementById('modal-pricelist-muda').classList.add('hidden')" class="absolute top-2 right-2 text-xl">&times;</button>
            <h2 class="text-lg font-bold mb-4">Tambah Pricelist</h2>
            <form action="{{ route('perhiasan.muda.ringkasan.pricelist.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm">Kadar</label>
                        <input type="number" name="kadar" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Harga - Minimum</label>
                        <input type="number" name="harga_min" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Harga - Maksimum</label>
                        <input type="number" name="harga_max" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="modal-penjualanLain-muda" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white w-full max-w-3xl rounded-lg p-6 shadow-lg relative">
            <button onclick="document.getElementById('modal-penjualanLain-muda').classList.add('hidden')" class="absolute top-2 right-2 text-xl">&times;</button>
            <h2 class="text-lg font-bold mb-4">Tambah Penjualan Lain</h2>
            <form action="{{ route('perhiasan.muda.ringkasan.penjualanLain.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm">Jenis Penjualan</label>
                        <input type="text" name="jenis_penjualan" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Berat</label>
                        <input type="number" name="berat" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Harga</label>
                        <input type="number" name="harga" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Keterangan</label>
                        <input type="text" name="keterangan" class="w-full border px-3 py-2 rounded">
                    </div>
                </div>

                <div class="mt-4 text-right">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div id="modal-pengeluaran-muda" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white w-full max-w-3xl rounded-lg p-6 shadow-lg relative">
            <button onclick="document.getElementById('modal-pengeluaran-muda').classList.add('hidden')" class="absolute top-2 right-2 text-xl">&times;</button>
            <h2 class="text-lg font-bold mb-4">Tambah pengeluaran</h2>
            <form action="{{ route('perhiasan.muda.ringkasan.pengeluaran.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm">Nama Pengeluaran</label>
                        <input type="text" name="nama_pengeluaran" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Nilai</label>
                        <input type="number" name="jumlah" class="w-full border px-3 py-2 rounded" required>
                    </div>
                </div>

                <div class="mt-4 text-right">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div id="editModalRingkasanPengeluaran" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
            <h3 class="text-lg font-semibold mb-4">Edit Pengeluaran</h3>
            <form method="POST" id="editFormPengeluaran" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <input type="hidden" id="editId" name="id">
                    <div>
                        <label for="editNamaBarang" class="block text-sm font-medium">Nama</label>
                        <input type="text" name="namaBarang" id="editNamaBarang" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="editNilai" class="block text-sm font-medium">Nilai</label>
                        <input type="text" name="nilai" id="editNilai" class="w-full border rounded px-2 py-1" required>
                    </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModalRingkasanPengeluaran()" class="bg-gray-400 px-4 py-2 text-white rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 px-4 py-2 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openEditModalRingkasanPengeluaran(button) {
            const modal = document.getElementById('editModalRingkasanPengeluaran');
            modal.classList.remove('hidden');

            const id = button.getAttribute('data-id');
            const namaBarang = button.getAttribute('data-nama_barang');
            const nilai = button.getAttribute('data-nilai');

            const form = modal.querySelector('form');
            form.action = `/perhiasan-muda/ringkasan/pengeluaran/${id}`;
            form.querySelector('input[name="namaBarang"]').value = namaBarang;
            form.querySelector('input[name="nilai"]').value = nilai;
        }
        function closeModalRingkasanPengeluaran() {
            document.getElementById('editModalRingkasanPengeluaran').classList.add('hidden');
        }
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.display = 'none';
            }
        }, 5000);
    </script>
</x-app-layout>
