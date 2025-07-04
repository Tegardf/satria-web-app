<x-app-layout class="bg-perhiasan-muda">
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Perhiasan Muda</h2>
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
                    <div class="text-3xl font-semibold">Saldo Awal Gesek</div>
                    <div class="text-4xl font-semibold">RP {{ number_format($saldoAwal, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="flex w-full h-40 items-center bg-card-gradient-3 text-purple-900 p-4 rounded-xl shadow">
                <div class="flex flex-1 h-full flex-col items-center justify-center gap-4 z-10 text-secondary-300">
                    <div class="text-3xl font-semibold">Saldo akhir Gesek</div>
                    <div class="text-4xl font-semibold">RP {{ number_format($saldoAkhir, 0, ',', '.') }}</div>
                </div>
                <img src="{{ asset('penjualan-tua-ringkasan-2.svg') }}" alt="Stok Icon" class="absolute z-0 w-36 h-36 right-10">
            </div>
        </div>
        <div class="w-full grid grid-cols-2 gap-10">
            @foreach ($perBankData as $bank => $records)
            <div class="col-span-1 bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <img src="{{ asset('bank-' . strtolower($bank) . '.png') }}" class="h-8" />
                    <div class="p-2 border-2 rounded-xl border-blue-800 text-xl font-semibold text-blue-800">
                        RP {{ number_format($records->sum('masuk') - $records->sum('keluar'), 0, ',', '.') }}
                    </div>
                </div>

                <table class="min-w-full border-collapse text-sm text-gray-800">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 px-4">Nama</th>
                            <th class="py-2 px-4">Masuk</th>
                            <th class="py-2 px-4">Keluar</th>
                            <th class="py-2 px-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $item)
                            <tr>
                                <td class="py-2 px-4">{{ $item->nama }}</td>
                                <td class="py-2 px-4">Rp. {{ number_format($item->masuk, 0, ',', '.') }}</td>
                                <td class="py-2 px-4">Rp. {{ number_format($item->keluar, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 text-right">
                                    <form method="POST" action="{{ route('perhiasan.muda.gesek.destroy', $item['id']) }}">
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
                            <tr><td colspan="3" class="text-center text-gray-500">No Data</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-yellow-100 font-semibold">
                            <td class="py-2 px-4 italic">Jumlah</td>
                            <td class="py-2 px-4 text-purple-600">
                                Rp. {{ number_format($bankSums[$bank]['total_masuk'], 0, ',', '.') }}
                            </td>
                            <td class="py-2 px-4 text-purple-600">
                                Rp. {{ number_format($bankSums[$bank]['total_keluar'], 0, ',', '.') }}
                            </td>
                            <th class="py-2 px-4"></th>

                        </tr>
                    </tfoot>
                </table>
                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $records->appends(request()->except(strtolower($bank)))->links('pagination::tailwind') }}
                </div>
                <div class="text-right my-4">
                    <button
                        onclick="openModalWithBank('{{ $bank }}')"
                        class="bg-secondary-700 text-white px-4 py-2 rounded hover:bg-secondary-800"
                    >
                        Tambah
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div id="inputModalGesek" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
            <button onclick="document.getElementById('inputModalGesek').classList.add('hidden')" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
            <h3 class="text-lg font-semibold mb-4">Tambah Pembelian</h3>
            <form method="POST" action="{{ route('perhiasan.muda.gesek.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="hidden">
                        <label for="id_perhiasan" class="block text-sm font-medium">Nama Barang</label>
                        <input value="2" type="number" name="id_perhiasan" id="id_perhiasan" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div class="hidden">
                        <label for="nama_bank" class="block text-sm font-medium">Nama Bank</label>
                        <input value="" type="text" name="nama_bank" id="nama_bank" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="nama" class="block text-sm font-medium">Nama</label>
                        <input type="text" name="nama" id="nama" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="masuk" class="block text-sm font-medium">Masuk</label>
                        <input type="number" name="masuk" id="masuk" class="w-full border rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="keluar" class="block text-sm font-medium">Keluar</label>
                        <input type="number" step="0.001" name="keluar" id="keluar" class="w-full border rounded px-2 py-1" required>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openModalWithBank(bankName) {
            document.getElementById('inputModalGesek').classList.remove('hidden');
            document.getElementById('nama_bank').value = bankName;
        }
        setTimeout(() => {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 3000);
    </script>
</x-app-layout>