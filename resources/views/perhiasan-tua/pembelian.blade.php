<x-app-layout class="bg-perhiasan-tua">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-message" class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Perhiasan Tua</h2>
    </x-slot>

    <x-perhiasan-tua-submenu/>

    <div class="my-10"> 
        <div class=" bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-purple-800 mb-4">Pembelian</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-sm text-gray-800 border-gray-300">
                    <thead>
                        <tr class="text-left bg-gray-200">
                            <th class="py-2 px-4 border">No</th>
                            <th class="py-2 px-4 border">Item</th>
                            <th class="py-2 px-4 border">Nama Barang</th>
                            <th class="py-2 px-4 border">Kadar</th>
                            <th class="py-2 px-4 border">Berat</th>
                            <th class="py-2 px-4 border">Harga</th>
                            <th class="py-2 px-4 border">Kode</th>
                            <th class="py-2 px-4 border">/Gr Beli</th>
                            <th class="py-2 px-4 border">/Gr Jual</th>
                            <th class="py-2 px-4 border">Keterangan</th>
                            <th class="py-2 px-4 border">Sales</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pembelians ?? [] as $item)
                            <tr>
                                <td class="py-2 px-4 border">{{($items->currentPage() - 1) * $items->perPage() + $loop->iteration }}</td>
                                <td class="py-2 px-4 border">{{ $item['perhiasan'] }}</td>
                                <td class="py-2 px-4 border">{{ $item['nama_barang'] }}</td>
                                <td class="py-2 px-4 border">{{ $item['kadar'] }}%</td>
                                <td class="py-2 px-4 border">{{ number_format($item['berat'], 3) }} Gr</td>
                                <td class="py-2 px-4 border">Rp. {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">{{ $item['kode'] }}</td>
                                <td class="py-2 px-4 border">Rp. {{ number_format($item['harga_per_gram_beli'], 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">Rp. {{ number_format($item['harga_per_gram_jual'], 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border">{{ $item['keterangan'] }}</td>
                                <td class="py-2 px-4 border">{{ $item['sales'] }}</td>
                                <td class="p-2 flex flex-row gap-6 justify-center border">
                                    <button
                                        onclick="openEditModalPembelianTua(this)"
                                        data-id="{{ $item['id'] }}"
                                        data-nama_barang="{{ $item['nama_barang'] }}"
                                        data-kode="{{ $item['kode'] }}"
                                        data-kadar="{{ $item['kadar'] }}"
                                        data-berat="{{ $item['berat'] }}"
                                        data-pergram_beli="{{ $item['harga_per_gram_beli'] }}"
                                        data-pergram_jual="{{ $item['harga_per_gram_jual'] }}"
                                        data-sales="{{ $item['sales'] }}"
                                        data-tanggal="{{ $item['tanggal'] ?? '' }}"
                                        data-keterangan="{{ $item['keterangan'] }}"

                                        class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    <form method="POST" action="{{ route('perhiasan.tua.pembelian.destroy', $item['id']) }}">
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
                                <td colspan="12" class="text-center text-gray-500 py-4 border">Data Unavailable</td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if(isset($pembelians) && $pembelians->count() > 0)
                    <tfoot>
                        <tr class="bg-yellow-100 font-semibold">
                            <td colspan="4" class="py-2 px-4 italic border">Jumlah</td>
                            <td class="py-2 px-4 text-purple-600 border">{{ number_format($totalBerat , 3) }} Gr</td>
                            <td class="py-2 px-4 text-purple-600 border">Rp. {{ number_format($totalHarga , 0, ',', '.') }}</td>
                            <td colspan="2" class="py-2 px-4 text-purple-600 border">
                                Rata / Gram: Rp. {{ number_format($rataHargaPerGram , 0, ',', '.') }}
                            </td>
                            <td colspan="4" class="border"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
                <div class="text-right my-4">
                    <button onclick="document.getElementById('inputModalPembelianTua').classList.remove('hidden')" class="bg-secondary-700 text-white px-4 py-2 rounded hover:bg-secondary-800">
                        Tambah
                    </button>
                </div>

                {{-- Pagination --}}
                @if(isset($items) && $items->count() > 0)
                <div class="mt-4 flex justify-center">
                    {{ $items->withQueryString()->links('pagination::tailwind') }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <div id="inputModalPembelianTua" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
            <button onclick="document.getElementById('inputModalPembelianTua').classList.add('hidden')" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
            <h3 class="text-lg font-semibold mb-4">Tambah Pembelian</h3>
            <form method="POST" action="{{ route('perhiasan.tua.pembelian.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="hidden">
                        <input type="number" name="id_bulan" id="id_bulan" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div class="hidden">
                        <input value="1" type="number" name="id_perhiasan" id="id_perhiasan" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="id_produk" class="block text-sm font-medium">Jenis Produk</label>
                        <select name="id_produk" id="id_produk" class="w-full border rounded px-2 py-1" required>
                            @foreach($produks as $p)
                                <option value="{{ $p->id }}">{{ $p->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label for="kode" class="block text-sm font-medium">Kode</label>
                        <input type="number" name="kode" id="kode" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="nama_barang" class="block text-sm font-medium">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="kadar" class="block text-sm font-medium">Kadar</label>
                        <input type="number" step="0.001" name="kadar" id="kadar" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="berat" class="block text-sm font-medium">Berat</label>
                        <input type="number" step="0.001" name="berat" id="berat" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="pergram_beli" class="block text-sm font-medium">Harga per Gram Beli</label>
                        <input type="number" step="0.01" name="pergram_beli" id="pergram_beli" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="pergram_jual" class="block text-sm font-medium">Harga per Gram Jual</label>
                        <input type="number" step="0.01" name="pergram_jual" id="pergram_jual" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="sales" class="block text-sm font-medium">Sales</label>
                        <input type="text" name="sales" id="sales" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div class="col-span-2">
                        <label for="keterangan" class="block text-sm font-medium">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="2" class="w-full border rounded px-2 py-1"></textarea>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModalPembelianTua" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
            <h3 class="text-lg font-semibold mb-4">Edit Pembelian</h3>
            <form method="POST" id="editFormPembelianTua" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <input type="hidden" id="editId" name="id">
                    <div>
                        <label for="editKode" class="block text-sm font-medium">Kode</label>
                        <input type="number" name="kode" id="editKode" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Tanggal</label>
                        <input type="date" name="tanggal" id="editTanggal" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="editNama_barang" class="block text-sm font-medium">Nama Barang</label>
                        <input type="text" name="nama_barang" id="editNama_barang" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="editKadar" class="block text-sm font-medium">Kadar</label>
                        <input type="number" step="0.001" name="kadar" id="editKadar" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="editBerat" class="block text-sm font-medium">Berat</label>
                        <input type="number" step="0.001" name="berat" id="editBerat" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="editPergramBeli" class="block text-sm font-medium">Harga per Gram Beli</label>
                        <input type="number" step="0.01" name="pergram_beli" id="editPergramBeli" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="editPergramJual" class="block text-sm font-medium">Harga per Gram Jual</label>
                        <input type="number" step="0.01" name="pergram_jual" id="editPergramJual" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="editSales" class="block text-sm font-medium">Sales</label>
                        <input type="text" name="sales" id="editSales" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div class="col-span-2">
                        <label for="editKeterangan" class="block text-sm font-medium">Keterangan</label>
                        <textarea name="keterangan" id="editKeterangan" rows="2" class="w-full border rounded px-2 py-1"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModalPembelianTua()" class="bg-gray-400 px-4 py-2 text-white rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 px-4 py-2 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openEditModalPembelianTua(button) {
            // Get data from HTML attributes
            const data = button.dataset;

            // Fill form
            document.getElementById('editId').value = data.id;
            document.getElementById('editKode').value = data.kode;
            document.getElementById('editNama_barang').value = data.nama_barang;
            document.getElementById('editKadar').value = data.kadar;
            document.getElementById('editBerat').value = data.berat;
            document.getElementById('editPergramBeli').value = data.pergram_beli;
            document.getElementById('editPergramJual').value = data.pergram_jual;
            document.getElementById('editSales').value = data.sales;
            document.getElementById('editKeterangan').value = data.keterangan;
            document.getElementById('editTanggal').value = data.tanggal;

            // Set form action dynamically
            const baseUrl = @json(route('perhiasan.tua.pembelian.update', ['id' => '__ID__']));
            document.getElementById('editFormPembelianTua').action = baseUrl.replace('__ID__', data.id);

            // Show modal
            document.getElementById('editModalPembelianTua').classList.remove('hidden');
        }

        function closeModalPembelianTua() {
            document.getElementById('editModalPembelianTua').classList.add('hidden');
        }
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.display = 'none';
            }
        }, 5000);
        document.addEventListener('DOMContentLoaded', function () {
            const tanggalInput = document.getElementById('tanggal');
            const idBulanInput = document.getElementById('id_bulan');

            tanggalInput.addEventListener('input', function () {
                if (this.value) {
                    const date = new Date(this.value);
                    const month = date.getMonth() + 1;
                    console.log(month);
                    idBulanInput.value = month;
                }
            });
        });
    </script>
</x-app-layout>