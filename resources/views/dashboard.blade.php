<x-app-layout class="bg-neutral-400">
    <div class="grid grid-cols-3 gap-4">
        <div class="flex flex-col gap-4 col-span-2">
            <div class="flex flex-row justify-between my-4">
                <div>
                    <h2 class="font-bold text-3xl text-gray-800  leading-tight">Dashboard</h2>
                </div>
                <div class="mr-4 flex flex-row gap-6">
                    <img src="{{ asset('notification.svg') }}" class="w-14 h-14 bg-white rounded-full p-2 ring-1 ring-green-500 " alt="user">
                    <img src="{{ asset('user.svg') }}" class="w-14 h-14 bg-white rounded-full p-2 ring-1 ring-green-500 " alt="user">
                </div>
            </div>
            <div class="flex flex-row gap-10">
                <div class="flex w-full h-40 items-center bg-card-gradient-5 text-purple-900 p-4 rounded-xl shadow relative">
                    <div class="flex flex-1 h-full flex-col items-center justify-center gap-4 z-10 text-secondary-300">
                        <div class="text-2xl font-semibold">KEUNTUNGAN</div>
                        <div class="text-xl font-semibold">Rp {{ number_format($keuntungan, 0, ',', '.') }}</div>
                    </div>
                    <img src="{{ asset('keuntungan.svg') }}" alt="Stok Icon" class="absolute z-0 w-28 right-1">
                </div>
                <div class="flex w-full h-40 items-center bg-card-gradient-4 text-purple-900 p-4 rounded-xl shadow relative">
                    <div class="flex flex-1 h-full flex-col items-center justify-center gap-4 z-10 text-secondary-300">
                        <div class="text-2xl font-semibold">PEMASUKAN</div>
                        <div class="text-xl font-semibold">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
                    </div>
                    <img src="{{ asset('pemasukan.svg') }}" alt="Stok Icon" class="absolute z-0 w-28 right-1">
                </div>
                <div class="flex w-full h-40 items-center bg-card-gradient-4 text-purple-900 p-4 rounded-xl shadow relative">
                    <div class="flex flex-1 h-full flex-col items-center justify-center gap-4 z-10 text-secondary-300">
                        <div class="text-2xl font-semibold">PERSEDIAAN</div>
                        <div class="text-xl font-semibold">{{ number_format($persediaan) }} Gram</div>
                    </div>
                    <img src="{{ asset('persediaan.svg') }}" alt="Stok Icon" class="absolute z-0 w-28 right-1">
                </div>
            </div>
            <div class=" bg-white rounded-xl p-4 shadow">
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-lg">Arus Kas</h2>
                    <select id="chartModeSelect" class="border border-gray-300 pr-10 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent shadow-sm bg-white">
                        <option class="px-2 mx-2" value="monthly"  @selected(request('mode') == 'monthly')>Monthly</option>
                        <option class="px-2" value="weekly" @selected(request('mode') == 'weekly')>Weekly</option>
                    </select>
                </div>
                <canvas id="barChart" height="150"></canvas>
            </div>
            <div class="bg-white p-4 rounded-xl shadow">
                <h2 class="font-semibold text-lg mb-2">Transaksi Akhir</h2>
                <table class="w-full text-sm text-left ">
                    <thead class="bg-purple-100 text-purple-700">
                        <tr>
                            <th class="p-2 border border-purple-700">Item</th>
                            <th class="p-2 border border-purple-700">%</th>
                            <th class="p-2 border border-purple-700">Berat</th>
                            <th class="p-2 border border-purple-700">Harga</th>
                            <th class="p-2 border border-purple-700">Kode</th>
                            <th class="p-2 border border-purple-700">/Gr</th>
                            <th class="p-2 border border-purple-700">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi ?? [] as $t)
                        <tr class="border-b">
                            <td class="p-2 border border-gray-400">{{ $t['item'] }}</td>
                            <td class="p-2 border border-gray-400">{{ $t['persen'] }}%</td>
                            <td class="p-2 border border-gray-400">{{ $t['berat'] }} Gr</td>
                            <td class="p-2 border border-gray-400">Rp {{ number_format($t['harga']) }}</td>
                            <td class="p-2 border border-gray-400">{{ $t['kode'] }}</td>
                            <td class="p-2 border border-gray-400">Rp {{ number_format($t['pergram']) }}</td>
                            <td class="p-2 border border-gray-400">{{ $t['ket'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">Data Unavailable</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col col-span-1 gap-4">
            <div class="bg-white rounded-xl p-4 shadow">
                <h2 class="font-semibold text-lg mb-4">Statistik Penjualan</h2>
                <canvas id="donutChart" height="200"></canvas>
            </div>
            <div class="col-span-1 bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-purple-800 mb-4">Price List</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-gray-800">
                        <thead>
                            <tr class="text-left bg-gray-200">
                                <th class="py-2 px-4 border border-gray-400">Kadar</th>
                                <th class="py-2 px-4 border border-gray-400">Max</th>
                                <th class="py-2 px-4 border border-gray-400">Min</th>

                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($pricelists ?? [] as $item)
                                <tr>
                                    <td class="py-2 px-4 border border-gray-400">{{ $item['kadar'] ?? '-' }}K</td>
                                    <td class="py-2 px-4 border border-gray-400">Rp. {{ number_format($item['harga_max'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border border-gray-400">Rp. {{ number_format($item['harga_min'] ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 py-4">Data Unavailable</td>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let barChart = new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartDays) !!},
                datasets: [
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($pengeluaran) !!},
                        backgroundColor: 'rgba(0, 255, 255, 0.6)'
                    },
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($pemasukanBar) !!},
                        backgroundColor: 'rgba(128, 0, 255, 0.6)'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        document.getElementById('chartModeSelect').addEventListener('input', function () {
            const mode = this.value;
            window.location.href = `/dashboard?mode=${mode}`;
        });

        const donutChart = new Chart(document.getElementById('donutChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($penjualanLabel) !!},
                datasets: [{
                    data: {!! json_encode($penjualanValue) !!},
                    backgroundColor: ['#E5BF5E', '#014439', '#1BFDD7', '#2D271B', '#612CDD', '#865EE5','#18cc00 ']
                }]
            },
            options: {
                cutout: '70%',
                responsive: true
            }
        });
    </script>
</x-app-layout>
