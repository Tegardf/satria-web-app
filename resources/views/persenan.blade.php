{{-- resources/views/persenan.blade.php --}}
<x-app-layout class="bg-neutral-400">
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800  leading-tight">Persenan</h2>
    </x-slot>

    <div class="py-12 flex flex-col items-center gap-6">
        <div class="grid grid-cols-2 w-full gap-6">
            <div class="col-span-1 bg-white p-6 rounded-xl shadow-md w-full">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-purple-800">Persenan Emas Tua</h2>
                     <select id="idTuaSelect" class="border border-purple-600 text-purple-800 px-3 py-1 rounded-md">
                        @foreach($histories as $history)
                            <option value="{{ $history->id }}" @selected(request('idTua') == $history->id)>
                                {{ ucfirst($history->bulan) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-center">
                        <thead class="text-gray-600 border-b bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-t border-l border-r border-gray-300">Tgl</th>
                                <th colspan="2" class="px-4 py-2 border border-gray-300">Penjualan</th>
                                <th colspan="2" class="px-4 py-2 border border-gray-300">Pembelian</th>
                            </tr>
                            <tr class="text-xs text-gray-600">
                                <th class="border-b border-l border-r border-gray-300"></th>
                                <th class="px-2 py-1 border border-gray-300">Berat</th>
                                <th class="px-2 py-1 border border-gray-300">Harga</th>
                                <th class="px-2 py-1 border border-gray-300">Berat</th>
                                <th class="px-2 py-1 border border-gray-300">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($perhiasanTua ?? [] as $row)
                                <tr class="bg-purple-50 rounded-lg">
                                    <td class="py-2 border border-gray-300">{{ $row['tanggal'] }}</td>
                                    <td class="border border-gray-300">{{ isset($row['penjualan']['berat']) 
                                            ? number_format($row['penjualan']['berat'], 0, ',', '.') 
                                            : '-' 
                                        }}
                                    </td>
                                    <td class="border border-gray-300">{{ isset($row['penjualan']['harga']) 
                                            ? number_format($row['penjualan']['harga'], 0, ',', '.') 
                                            : '-' 
                                        }}
                                    </td>
                                    <td class="border border-gray-300">{{ isset($row['pembelian']['berat']) 
                                            ? number_format($row['pembelian']['berat'], 0, ',', '.') 
                                            : '-' 
                                        }}
                                    </td>
                                    <td class="border border-gray-300">{{ isset($row['pembelian']['harga']) 
                                            ? number_format($row['pembelian']['harga'], 0, ',', '.') 
                                            : '-' 
                                        }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-400 italic border border-gray-300">Data tidak tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-yellow-100 text-sm font-semibold">
                            <tr>
                                <td class="italic py-2 border border-gray-300">Total</td>
                                <td class="border border-gray-300">{{ number_format(collect($perhiasanTua)->sum(fn($item) => $item['penjualan']['berat']) ?? 0, 0, ',', '.') }} Gr</td>
                                <td class="border border-gray-300">Rp. {{ number_format(collect($perhiasanTua)->sum('penjualan.harga') ?? 0, 0, ',', '.') }}</td>
                                <td class="border border-gray-300">{{ number_format(collect($perhiasanTua)->sum('pembelian.berat') ?? 0, 0, ',', '.') }} Gr</td>
                                <td class="border border-gray-300">Rp. {{ number_format(collect($perhiasanTua)->sum('pembelian.harga') ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-span-1 bg-white p-6 rounded-xl shadow-md w-full">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-purple-800">Persenan Emas Muda</h2>
                    <select id="idMudaSelect" class="border border-purple-600 text-purple-800 px-3 py-1 rounded-md">
                        @foreach($histories as $history)
                            <option value="{{ $history->id }}" @selected(request('idMuda') == $history->id)>
                                {{ ucfirst($history->bulan) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-center">
                        <thead class="text-gray-600 border-b bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border-t border-l border-r border-gray-300">Tgl</th>
                                <th colspan="2" class="px-4 py-2 border border-gray-300">Penjualan</th>
                                <th colspan="2" class="px-4 py-2 border border-gray-300">Pembelian</th>
                            </tr>
                            <tr class="text-xs text-gray-600">
                                <th class="border-b border-l border-r border-gray-300"></th>
                                <th class="px-2 py-1 border border-gray-300">Berat</th>
                                <th class="px-2 py-1 border border-gray-300">Harga</th>
                                <th class="px-2 py-1 border border-gray-300">Berat</th>
                                <th class="px-2 py-1 border border-gray-300">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($perhiasanMuda ?? [] as $row)
                                <tr class="bg-purple-50 rounded-lg">
                                    <td class="py-2 border border-gray-300">{{ $row['tanggal'] }}</td>
                                    <td class="border border-gray-300">{{ isset($row['penjualan']['berat']) 
                                            ? number_format($row['penjualan']['berat'], 0, ',', '.') 
                                            : '-' 
                                        }}
                                    </td>
                                    <td class="border border-gray-300">{{ isset($row['penjualan']['harga']) 
                                            ? number_format($row['penjualan']['harga'], 0, ',', '.') 
                                            : '-' 
                                        }}
                                    </td>
                                    <td class="border border-gray-300">{{ isset($row['pembelian']['berat']) 
                                            ? number_format($row['pembelian']['berat'], 0, ',', '.') 
                                            : '-' 
                                        }}
                                    </td>
                                    <td class="border border-gray-300">{{ isset($row['pembelian']['harga']) 
                                            ? number_format($row['pembelian']['harga'], 0, ',', '.') 
                                            : '-' 
                                        }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-400 italic border border-gray-300">Data tidak tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-yellow-100 text-sm font-semibold">
                            <tr>
                                <td class="italic py-2 border border-gray-300">Total</td>
                                <td class="border border-gray-300">{{ number_format(collect($perhiasanMuda)->sum(fn($item) => $item['penjualan']['berat']) ?? 0, 0, ',', '.') }} Gr</td>
                                <td class="border border-gray-300">Rp. {{ number_format(collect($perhiasanMuda)->sum('penjualan.harga') ?? 0, 0, ',', '.') }}</td>
                                <td class="border border-gray-300">{{ number_format(collect($perhiasanMuda)->sum('pembelian.berat') ?? 0, 0, ',', '.') }} Gr</td>
                                <td class="border border-gray-300">Rp. {{ number_format(collect($perhiasanMuda)->sum('pembelian.harga') ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
        <div class=" bg-white p-6 rounded-xl shadow-md w-full">


            <div class="space-y-2">
                <div class="flex justify-between border-b border-gray-200 py-1">
                    <span class="text-gray-700">Tua</span>
                    <span class="text-gray-700">Rp. {{ number_format($totalpersenanTua ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-200 py-1">
                    <span class="text-gray-700">Muda</span>
                    <span class="text-gray-700">Rp. {{ number_format($totalpersenanMuda ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-300 py-1 font-semibold text-purple-800">
                    <span>Total</span>
                    <span>Rp. {{ number_format(($totalpersenanMuda ?? 0) + ($totalpersenanTua ?? 0), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const idTuaSelect = document.getElementById('idTuaSelect');
        const idMudaSelect = document.getElementById('idMudaSelect');

        function updateURL() {
            const idTua = idTuaSelect.value;
            const idMuda = idMudaSelect.value;
            window.location.href = `/persenan?idTua=${idTua}&idMuda=${idMuda}`;
        }

        idTuaSelect.addEventListener('change', updateURL);
        idMudaSelect.addEventListener('change', updateURL);
    });
</script>
</x-app-layout>