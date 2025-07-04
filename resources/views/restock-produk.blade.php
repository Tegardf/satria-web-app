<x-app-layout class="bg-neutral-400">
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Restock Produk</h2>
    </x-slot>

    <div class="py-12 grid grid-cols-2 gap-6 w-full">
        @foreach ($grouped as $groupname => $restocks)
            <div class="col-span-1 w-full flex flex-col justify-between  bg-white rounded-xl shadow-md p-6">
                <div class="">
                    <h2 class="text-xl font-semibold text-purple-800 mb-4">{{$groupname}}</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse text-sm text-gray-800">
                            <thead>
                                <tr class="text-left border-b border-gray-200">
                                    <th class="py-2 px-4">Model</th>
                                    <th class="py-2 px-4">Berat/gr</th>
                                    <th class="py-2 px-4">Ukuran</th>
                                    <th class="py-2 px-4">Kedar</th>
                                    <th class="py-2 px-4">Biji</th>
                                    <th class="py-2 px-4"></th>
                                    <th class="py-2 px-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($restocks ?? [] as $restock)
                                    <tr>
                                        <td class="py-2 px-4">{{ $restock['model'] ?? '-' }}</td>
                                        <td class="py-2 px-4">{{ $restock['berat'] ?? '0.00' }}</td>
                                        <td class="py-2 px-4">{{ $restock['ukuran'] ?? '-' }}</td>
                                        <td class="py-2 px-4">{{ $restock['kadar'] ?? '0' }}%</td>
                                        <td class="py-2 px-4">{{ $restock['jumlah'] ?? '0' }} Gr</td>
                                        <td class="py-2 px-2">
                                            <input 
                                            data-id="{{ $restock->id }}"
                                            type="checkbox" 
                                            class="status-checkbox rounded-full w-5 h-5 text-primary-600 focus:ring-primary-500 border-gray-300"
                                            {{ $restock->status ? 'checked' : '' }}
                                            >
                                        </td>
                                        <td class="py-2 px-4 text-right">
                                        <form method="POST" action="{{ route('restocks.destroy', $restock->id) }}" onsubmit="return confirm('Hapus item ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M6 18L18 6M6 6l12 12"/>
                                                            </svg></button>
                                        </form>
                                    </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-gray-500 py-4">Data Unavailable</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        @if(isset($items) && $items->count() > 0)
                        <div class="mt-4 flex justify-center">
                            {{ $items->links('pagination::tailwind') }}
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Add Button -->
                <div class="flex justify-end mt-6">
                    <button onclick="openModalRestock('{{ Str::slug($groupname) }}')" class="mb-4 bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-800">
                    + Tambah Produk
                    </button>
                </div>

                <!-- Modal -->
                <div id="modal-{{ Str::slug($groupname) }}" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                    <div class="bg-white p-6 rounded-xl w-full max-w-lg relative">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800">Tambah Produk ke {{ $groupname }}</h3>
                        <form method="POST" action="{{ route('restocks.store') }}">
                            @csrf
                            <input type="hidden" name="id_perhiasan" value="{{ $restocks[0]['id_perhiasan']}}">
                            <input type="hidden" name="id_produk" value="{{ $restocks[0]['id_produk']}}">
                            <!-- <input type="hidden" name="group" value="{{ $groupname }}"> -->
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="model" placeholder="Model" class="border p-2 rounded" required>
                                <input type="number" step="0.01" name="berat" placeholder="Berat" class="border p-2 rounded" required>
                                <input type="text" name="ukuran" placeholder="Ukuran" class="border p-2 rounded" required>
                                <input type="number" step="0.01" name="kadar" placeholder="Kadar (%)" class="border p-2 rounded" required>
                                <input type="number" step="0.01" name="jumlah" placeholder="Jumlah (Gr)" class="border p-2 rounded" required>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="button" onclick="closeModalRestock('{{ Str::slug($groupname) }}')" class="mr-2 px-4 py-2 border rounded">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach`
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.status-checkbox').on('change', function () {
            const id = $(this).data('id');
            const status = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '{{ route("restocks.toggleStatus") }}',
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'
                    
                },
                success: function (response) {
                    console.log('Status updated!');
                },
                error: function () {
                    alert('Error updating status.');
                }
            });
        });
        function openModalRestock(group) {
            document.getElementById('modal-' + group).classList.remove('hidden');
            document.getElementById('modal-' + group).classList.add('flex');
        }

        function closeModalRestock(group) {
            document.getElementById('modal-' + group).classList.add('hidden');
            document.getElementById('modal-' + group).classList.remove('flex');
        }
    </script>
</x-app-layout>