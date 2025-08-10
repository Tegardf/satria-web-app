<x-app-layout class="{{request('perhiasan_id') == 1 ? 'bg-perhiasan-tua' : 'bg-perhiasan-muda'}}">
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Input Produk</h2>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-message" class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="py-12">
        <div class="w-full  ">
            <div class="w-full mb-4 flex flex-row gap-4">
                <form method="GET" action="{{ route('input.produk') }}" class="w-full">
                    <input type="hidden" name="perhiasan_id" value="1">
                    <input type="hidden" name="produk_id" value="{{request('produk_id')}}">
                    <button class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 active:bg-secondary-300 hover:bg-secondary-300 text-xl font-bold py-4 rounded-xl {{  request('perhiasan_id') == 1 ? 'bg-secondary-300':'bg-secondary-200'}}">Perhiasan Tua</button>
                </form>
                <form method="GET" action="{{ route('input.produk') }}" class="w-full">
                    <input type="hidden" name="perhiasan_id" value="2">
                    <input type="hidden" name="produk_id" value="{{request('produk_id')}}">
                    <button class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 active:bg-secondary-300 hover:bg-secondary-300 text-xl font-bold py-4 rounded-xl {{  request('perhiasan_id') == 2 ? 'bg-secondary-300':'bg-secondary-200'}}">Perhiasan Muda</button>
                </form>
                
            </div>
            <div x-data="{ open: false, selected: '{{ request('produk_id') ? $produks->firstWhere('id', request('produk_id'))->jenis : 'Pilih Jenis' }}' }" class="w-full mb-4">
                <button @click="open = !open"
                    class="w-full bg-primary-300 border-primary-800 border-2 text-primary-800 font-semibold px-4 py-2 text-lg rounded-xl text-center">
                    <span x-text="selected"></span>
                    <span class="float-right transform" :class="{ 'rotate-180': open }">v</span>
                </button>

                <ul x-show="open" @click.outside="open = false"
                    class="bg-perhiasan-tua rounded-xl my-2 transition-all duration-300 space-y-1 ">
                    @foreach($produks as $p)
                        <li>
                            <a href="{{ route('input.produk', ['perhiasan_id' => request('perhiasan_id'), 'produk_id' => $p->id ]) }}"
                                class="bg-white my-2 block px-4 py-2 text-lg text-center text-primary-800 hover:bg-primary-300 border-primary-800 border-2 rounded-xl {{ request()->get('produk_id') == $p->id ? 'hidden' : '' }}"
                                @click="selected = '{{ $p->Jenis }}'; open = false;">
                                {{ $p->jenis }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b  border-gray-200">
                    <h1 class="text-2xl text-primary-800 font-semibold text-center">Input Stok dan Detail Barang</h1>
                    <!-- Modal Trigger Button -->
                    <div class="text-right my-4">
                        <button onclick="document.getElementById('inputModal').classList.remove('hidden')" class="bg-secondary-700 text-white px-4 py-2 rounded hover:bg-secondary-800">
                            Tambah
                        </button>
                    </div>

                    <!-- Table -->
                    <div>
                        <table class="w-full text-sm text-left border border-gray-300 ">
                            <thead class="bg-gray-200 text-center">
                                <tr>
                                    <th class="border p-2">No</th>
                                    <th class="border p-2">Kode</th>
                                    <th class="border p-2">Nama Barang</th>
                                    <th class="border p-2">Tanggal</th>
                                    <th class="border p-2">Jumlah</th>
                                    <th class="border p-2">Kadar</th>
                                    <th class="border p-2">Berat Kotor</th>
                                    <th class="border p-2">Berat Bersih</th>
                                    <th class="border p-2">Berat Kitir</th>
                                    <th class="border p-2">Per Gram</th>
                                    <th class="border p-2">Real</th>
                                    <th class="border p-2">Rusak</th>
                                    <th class="border p-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($stocks->isEmpty())
                                    <tr>
                                        <td colspan="11" class="text-center py-4 text-gray-500">No stock data available. Please select jewelry type and category.</td>
                                    </tr>
                                @else
                                    @foreach($stocks as $stock)
                                        <tr class="text-center">
                                            <td class="border p-2">{{ ($stocks->currentPage() - 1) * $stocks->perPage() + $loop->iteration }}</td>
                                            <td class="border p-2">{{ $stock->kode }}</td>
                                            <td class="border p-2">{{ $stock->nama }}</td>
                                            <td class="border p-2">{{ $stock->tanggal }}</td>
                                            <td class="border p-2">{{ $stock->jumlah }}</td>
                                            <td class="border p-2">{{ $stock->kadar }}%</td>
                                            <td class="border p-2">{{ $stock->berat_kotor }} Gr</td>
                                            <td class="border p-2">{{ $stock->berat_bersih }} Gr</td>
                                            <td class="border p-2">{{ $stock->berat_kitir }} Gr</td>
                                            <td class="border p-2">Rp. {{ number_format($stock->pergram, 0, ',', '.') }}</td>
                                            <td class="border p-2">{{ $stock->real }}</td>
                                            <td class="border p-2">{{ $stock->rusak }}</td>
                                            </td>
                                            <td class="border p-2 flex flex-row gap-6 justify-center">
                                                <button
                                                    onclick="openEditModal(this)"
                                                    data-id="{{ $stock->id }}"
                                                    data-kode="{{ $stock->kode }}"
                                                    data-nama="{{ $stock->nama }}"
                                                    data-tanggal="{{ $stock->tanggal }}"
                                                    data-jumlah="{{ $stock->jumlah }}"
                                                    data-kadar="{{ $stock->kadar }}"
                                                    data-berat-kotor="{{ $stock->berat_kotor }}"
                                                    data-berat-bersih="{{ $stock->berat_bersih }}"
                                                    data-berat-kitir="{{ $stock->berat_kitir }}"
                                                    data-status="{{ $stock->rusak }}"
                                                    data-pergram="{{ $stock->pergram }}"
                                                    data-real="{{ $stock->real }}"
                                                    class="text-blue-600 hover:text-blue-800" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </button>
                                                <form method="POST" action="{{ route('stock.destroy', $stock->id) }}">
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
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4">
                            @if($stocks->isEmpty())
                            @else
                                {{ $stocks->links() }}
                            @endif
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="inputModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
                            <button onclick="document.getElementById('inputModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
                            <h3 class="text-lg font-semibold mb-4">Tambah Produk</h3>
                            <form method="POST" action="{{ route('stock.store') }}" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="id_perhiasan">Jenis Perhiasan</label>
                                        <select name="id_perhiasan" id="id_perhiasan" class="w-full border rounded">
                                            @foreach($perhiasans as $p)
                                                <option value="{{ $p->id }}">{{ $p->jenis }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="id_produk">Jenis Produk</label>
                                        <select name="id_produk" id="id_produk" class="w-full border rounded">
                                            @foreach($produks as $p)
                                                <option value="{{ $p->id }}">{{ $p->jenis }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div><input type="text" name="kode" placeholder="Kode" class="w-full border rounded"></div>
                                    <div><input type="text" name="nama" placeholder="Nama" class="w-full border rounded"></div>
                                    <div><input type="date" name="tanggal" class="w-full border rounded"></div>
                                    <div><input type="number" name="jumlah" placeholder="Jumlah" class="w-full border rounded"></div>
                                    <div><input type="number" step="0.01" name="kadar" placeholder="Kadar (%)" class="w-full border rounded"></div>
                                    <div><input type="number" step="0.001" name="berat_kotor" placeholder="Berat Kotor" class="w-full border rounded"></div>
                                    <div><input type="number" step="0.001" name="berat_bersih" placeholder="Berat Bersih" class="w-full border rounded"></div>
                                    <div><input type="number" step="0.001" name="berat_kitir" placeholder="Berat Kitir" class="w-full border rounded"></div>
                                    <div><input type="number" step="0.001" name="pergram" placeholder="Per Gram" class="w-full border rounded"></div>
                                    <div><input type="number" step="0.001" name="real" placeholder="Real" class="w-full border rounded"></div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-700">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-30 hidden flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                            <form id="editForm" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" id="editId" name="id">

                                <label>Kode:</label>
                                <input id="editKode" name="kode" class="w-full mb-2 p-2 border rounded" required>

                                <label>Nama:</label>
                                <input id="editNama" name="nama" class="w-full mb-2 p-2 border rounded" required>

                                <label>Tanggal:</label>
                                <input type="date" id="editTanggal" name="tanggal" class="w-full mb-2 p-2 border rounded" required>

                                <label>Jumlah:</label>
                                <input type="number" id="editJumlah" name="jumlah" class="w-full mb-2 p-2 border rounded" required>

                                <label>Kadar (%):</label>
                                <input type="number" step="0.01" id="editKadar" name="kadar" class="w-full mb-2 p-2 border rounded" required>

                                <label>Berat Kotor:</label>
                                <input id="editBeratKotor" name="berat_kotor" class="w-full mb-2 p-2 border rounded" required>

                                <label>Berat Bersih:</label>
                                <input id="editBeratBersih" name="berat_bersih" class="w-full mb-2 p-2 border rounded" required>

                                <label>Berat Kitir:</label>
                                <input id="editBeratKitir" name="berat_kitir" class="w-full mb-4 p-2 border rounded" required>

                                <label>Per Gram:</label>
                                <input type="number" step="0.001" id="editPerGram" name="pergram" class="w-full mb-2 p-2 border rounded" required>

                                <label>Real:</label>
                                <input type="number" step="0.001" id="editReal" name="real" class="w-full mb-4 p-2 border rounded" required>

                                <label>Rusak:</label>
                                <input type="number" id="editStatus" name="rusak" class="w-full mb-4 p-2 border rounded" required>

                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="closeModal()" class="bg-gray-400 px-4 py-2 text-white rounded">Cancel</button>
                                    <button type="submit" class="bg-blue-600 px-4 py-2 text-white rounded">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(button) {
            // Get data from HTML attributes
            const data = button.dataset;

            // Fill form
            document.getElementById('editId').value = data.id;
            document.getElementById('editKode').value = data.kode;
            document.getElementById('editNama').value = data.nama;
            document.getElementById('editTanggal').value = data.tanggal;
            document.getElementById('editJumlah').value = data.jumlah;
            document.getElementById('editKadar').value = data.kadar;
            document.getElementById('editBeratKotor').value = data.beratKotor;
            document.getElementById('editBeratBersih').value = data.beratBersih;
            document.getElementById('editBeratKitir').value = data.beratKitir;
            document.getElementById('editPerGram').value = data.pergram;
            document.getElementById('editReal').value = data.real;
            document.getElementById('editStatus').value = data.status;

            // Set form action dynamically
            const baseUrl = @json(route('stock.update', ['stock' => '__ID__']));
            document.getElementById('editForm').action = baseUrl.replace('__ID__', data.id);

            // Show modal
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.display = 'none';
            }
        }, 5000);

        
    </script>
</x-app-layout>
