<x-app-layout class="bg-perhiasan-muda">
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Perhiasan Muda</h2>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-message" class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <x-perhiasan-muda-submenu/>

    <div class="flex flex-col my-10">
        <div class="grid grid-cols-3 gap-4 py-2">
            <div class="col-span-2 rounded-lg">
                <div class=" bg-white rounded-xl shadow-md p-4 h-full">
                    <h2 class="text-xl font-semibold text-purple-800 mb-4">Stok Perhiasan Muda</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                            <thead>
                                <tr class="text-left bg-gray-200">
                                    <th class="py-2 px-4 border">No</th>
                                    <th class="py-2 px-4 border">Item</th>
                                    <th class="py-2 px-4 border">Stok Awal</th>
                                    <th class="py-2 px-4 border">Keluar</th>
                                    <th class="py-2 px-4 border">Sisa Stok</th>
                                    <th class="py-2 px-4 border">Real</th>
                                    <th class="py-2 px-4 border">Selisih</th>
                                    <th class="py-2 px-4 border">Berat Total</th>
                                    <th class="py-2 px-4 border">Harga Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($stocks ?? [] as $item)
                                <tr>
                                    <td class="py-2 px-4 border">{{ ($stocksRaw->currentPage() - 1) * $stocksRaw->perPage() + $loop->iteration }}</td>
                                    <td class="py-2 px-4 border">{{ $item['item'] }}</td>
                                    <td class="py-2 px-4 border">{{ $item['stok_awal'] }}</td>
                                    <td class="py-2 px-4 border">{{ $item['keluar'] }}</td>
                                    <td class="py-2 px-4 border">{{ $item['sisa_stok'] }}</td>
                                    <td class="py-2 px-4 border">{{ $item['real'] }}</td>
                                    <td class="py-2 px-4 border">{{ abs($item['selisih']) }}</td>
                                    <td class="py-2 px-4 border">{{ number_format($item['berat_total'], 2, ',', '.') }} Gr</td>
                                    <td class="py-2 px-4 border">Rp {{ number_format($item['harga_total'], 2, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-4">Data Unavailable</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        @if(isset($stocksRaw) && $stocksRaw->count() > 0)
                        <div class="mt-4 flex justify-center">
                            {{ $stocksRaw->withQueryString()->links('pagination::tailwind') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        <!-- 2/3 width -->
        <div class="col-span-1">
            <div class="space-y-4">
                <!-- Card 1 -->
                <div class="flex h-44 items-center justify-between bg-card-gradient-1 text-purple-900 p-4 rounded-xl shadow">
                    <div class="flex h-full flex-col items-start">
                        <div class="text-sm font-semibold">Stok Total</div>
                        <div class="text-xl font-bold">{{ number_format($totalBerat, 2, ',', '.') }} Gram</div>
                    </div>
                    <img src="{{ asset('Stock-total.svg') }}" alt="Stok Icon" class="w-40 h-40">

                </div>

                <!-- Card 2 -->
                <div class="flex h-44 items-center justify-between bg-card-gradient-1 text-purple-900 p-4 rounded-xl shadow">
                    <div class="flex h-full flex-col items-start">
                        <div class="text-sm font-semibold">Harga Total</div>
                        <div class="text-xl font-bold">Rp {{ number_format($totalHarga, 2, ',', '.') }}</div>
                    </div>
                    <img src="{{ asset('harga-total.svg') }}" alt="Harga Icon" class="w-40 h-40">
                </div>

                <!-- Card 3 -->
                <div class="flex h-44 items-center justify-between bg-card-gradient-1 text-purple-900 p-4 rounded-xl shadow">
                    <div class="flex h-full flex-col items-start">
                        <div class="text-sm font-semibold">Rata / Gram</div>
                        <div class="text-xl font-bold">Rp {{ number_format($rataPerGram, 2, ',', '.') }}</div>
                    </div>
                    <img src="{{ asset('rata-pergram.svg') }}" alt="Rata Icon" class="w-40 h-40">
                </div>
            </div>
        </div>
    </div>
    <div class=" bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-purple-800 mb-4">Penjualan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                    <thead>
                        <tr class="text-left bg-gray-200">
                            <th class="py-2 px-4 border">No</th>
                            <th class="py-2 px-4 border">Item</th>
                            <th class="py-2 px-4 border">Tanggal</th>
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
                            <th class="py-2 px-4 border">Aksi</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($penjualans ?? [] as $item)
                            <tr>
                                <td class="py-2 px-4 border">{{ ($penjualansRaw->currentPage() - 1) * $penjualansRaw->perPage() + $loop->iteration }}</td>
                                <td class="py-2 px-4 border">{{ $item['item'] ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $item['tanggal'] ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $item['nama_barang'] ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $item['kadar'] ?? '-' }}%</td>
                                <td class="py-2 px-4 border">{{ $item['berat'] ?? '0.000' }} Gr</td>
                                <td class="py-2 px-4 border">Rp. {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">{{ $item['jumlah_keluar'] ?? 0 }}</td>
                                <td class="py-2 px-4 border">{{ $item['kode'] ?? 0 }}</td>
                                <td class="py-2 px-4 border">Rp. {{ number_format($item['pergram_beli'] ?? 0, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">Rp. {{ number_format($item['harga_jual'] ?? 0, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">{{ $item['keterangan'] ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $item['sales'] ?? '-' }}</td>
                                <td class="p-2 flex flex-row gap-6 justify-center border-b border-r">
                                    <button
                                        onclick="openEditModalPenjualan(this)"
                                        data-id="{{ $item['id'] }}"
                                        data-nama_barang="{{ $item['nama_barang'] }}"
                                        data-kode="{{ $item['kode'] }}"
                                        data-kadar="{{ $item['kadar'] }}"
                                        data-berat="{{ $item['berat'] }}"
                                        data-pergram_beli="{{ $item['pergram_beli'] }}"
                                        data-pergram_jual="{{ $item['harga_jual'] }}"
                                        data-sales="{{ $item['sales'] }}"
                                        data-jumlah_keluar="{{ $item['jumlah_keluar'] }}"
                                        data-keterangan="{{ $item['keterangan'] }}"
                                        data-tanggal="{{ $item['tanggal'] ?? '' }}"
                                        class="text-blue-600 hover:text-blue-800"
                                        title="Edit"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>

                                    <form method="POST" action="{{ route('perhiasan.muda.penjualan.destroy', $item['id']) }}">
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
                                <td colspan="14" class="text-center text-gray-500 py-4">Data Unavailable</td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if(isset($penjualans) && $penjualans->count() > 0)
                    <tfoot>
                        <tr class="bg-yellow-100 font-semibold">
                            <td colspan="4" class="py-2 px-4 italic border">Jumlah</td>
                            <td colspan="2" class="py-2 px-4 text-purple-600 border">Berat Total: {{ number_format($penjualans->sum('berat') ?? 0, 3) }} Gr</td>
                            <td colspan="3" class="py-2 px-4 text-purple-600 border">Harga Total: Rp. {{ number_format($penjualans->sum('harga') ?? 0, 0, ',', '.') }}</td>
                            <td colspan="5" class="py-2 px-4 text-purple-600 border">
                                Rata / Gram: Rp. {{ number_format($penjualans->avg('pergram_beli') ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>

                <div class="text-right my-4">
                    <button onclick="document.getElementById('modal-penjualan').classList.remove('hidden')" class="bg-secondary-700 text-white px-4 py-2 rounded hover:bg-secondary-800">
                        Tambah
                    </button>
                </div>

                {{-- Pagination --}}
                @if(isset($items) && $items->count() > 0)
                <div class="mt-4 flex justify-center">
                    {{ $items->links('pagination::tailwind') }}
                </div>
                @endif
            </div>
    </div>
    <div id="modal-penjualan" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white w-full max-w-3xl rounded-lg p-6 shadow-lg relative">
            <button onclick="document.getElementById('modal-penjualan').classList.add('hidden')" class="absolute top-2 right-2 text-xl">&times;</button>
            <h2 class="text-lg font-bold mb-4">Tambah Penjualan</h2>
            <form action="{{ route('perhiasan.muda.penjualan.store') }}" method="POST">
                @csrf
                <div class="mb-2  flex justify-end">
                    <input type="text" id="searchInputMuda" placeholder="Cari Kode..." 
                        class="border rounded px-3 py-2 w-1/3" onkeyup="filterTableMuda()">
                </div>
                <div class="overflow-y-auto h-64 border rounded mb-4">
                    <table class="table-auto w-full text-sm">
                        <thead class="bg-gray-100 font-semibold">
                            <tr>
                                <th class="py-2 px-4">Pilih</th>
                                <th class="py-2 px-4">Item</th>
                                <th class="py-2 px-4">Jumlah</th>
                                <th class="py-2 px-4">Berat</th>
                                <th class="py-2 px-4">Harga Stock</th>
                                <th class="py-2 px-4">Kode</th>
                            </tr>
                        </thead>
                        <tbody id="stocksTable">
                            @foreach ($stocksNormal as $stock)
                                <tr class="border-t">
                                    <td class="py-2 px-4">
                                        <input type="radio" name="id_stock" value="{{ $stock->id }}" required>
                                    </td>
                                    <td class="py-2 px-4">{{ $stock->produk->nama ?? $stock->nama }}</td>
                                    <td class="py-2 px-4">{{ $stock->jumlah }}</td>
                                    <td class="py-2 px-4">{{ $stock->berat_bersih }}</td>
                                    <td class="py-2 px-4">Rp. {{ number_format($stock->pergram, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4">{{ $stock->kode }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm">Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Sales</label>
                        <input type="text" name="sales" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Jumlah Terjual</label>
                        <input type="number" name="jumlah_keluar" min="1" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm">Harga per Gram</label>
                        <input type="number" step="0.01" name="pergram" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm">Keterangan</label>
                        <textarea name="keterangan" rows="2" class="w-full border px-3 py-2 rounded"></textarea>
                    </div>
                </div>

                <div class="mt-4 text-right">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div id="editModalPenjualanmuda" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
            <h3 class="text-lg font-semibold mb-4">Edit Penjualan</h3>
            <form method="POST" id="editFormPenjualanmuda" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editPenjualanId">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Kode</label>
                        <input type="text" id="editKode" class="w-full border rounded px-2 py-1 bg-gray-200" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Nama Barang</label>
                        <input type="text" id="editNamaBarang" class="w-full border rounded px-2 py-1 bg-gray-200" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Berat Bersih</label>
                        <input type="number" id="editBeratBersih" class="w-full border rounded px-2 py-1 bg-gray-200" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Kadar</label>
                        <input type="number" id="editKadar" class="w-full border rounded px-2 py-1 bg-gray-200" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Harga Beli</label>
                        <input type="number" id="editHargaBeli" class="w-full border rounded px-2 py-1 bg-gray-200" disabled>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Tanggal</label>
                        <input type="date" name="tanggal" id="editTanggal" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Jumlah Terjual</label>
                        <input type="number" name="jumlah_keluar" id="editJumlahKeluar" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Harga per Gram</label>
                        <input type="number" step="0.01" name="pergram" id="editPergram_jual" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Sales</label>
                        <input type="text" name="sales" id="editSales" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Keterangan</label>
                        <textarea name="keterangan" id="editKeterangan" rows="2" class="w-full border rounded px-2 py-1"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" onclick="closeEditModalPenjualan()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModalPenjualan(button) {
            const penjualan = button.dataset;

            // Fill stock-related fields
            document.getElementById('editPenjualanId').value = penjualan.id;
            document.getElementById('editKode').value = penjualan.kode;
            document.getElementById('editNamaBarang').value = penjualan.nama_barang;
            document.getElementById('editBeratBersih').value = penjualan.berat;
            document.getElementById('editKadar').value = penjualan.kadar;

            // Fill penjualan editable fields
            document.getElementById('editTanggal').value = penjualan.tanggal;
            document.getElementById('editJumlahKeluar').value = penjualan.jumlah_keluar;
            document.getElementById('editHargaBeli').value = penjualan.pergram_beli;
            document.getElementById('editPergram_jual').value = penjualan.pergram_jual;
            document.getElementById('editSales').value = penjualan.sales;
            document.getElementById('editKeterangan').value = penjualan.keterangan;

            // Set form action dynamically
            document.getElementById('editFormPenjualanmuda').action = `/perhiasan-muda/penjualan/${penjualan.id}`;

            // Show modal
            document.getElementById('editModalPenjualanmuda').classList.remove('hidden');
        }
        function filterTableMuda() {
            let input = document.getElementById("searchInputMuda").value.toUpperCase();
            let rows = document.querySelectorAll("#stocksTable tr");

            rows.forEach(rows => {
                let kodeCell = rows.querySelectorAll("td")[5];
                if (kodeCell) {
                    if (kodeCell) {
                        let kode = kodeCell.textContent || kodeCell.innerText;
                        rows.style.display = kode.toUpperCase().includes(input) ? "" : "none";
                    }
                }
            });
        }
        function closeEditModalPenjualan() {
            document.getElementById('editModalPenjualanmuda').classList.add('hidden');
        }
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.display = 'none';
            }
        }, 5000);
    </script>
</x-app-layout>