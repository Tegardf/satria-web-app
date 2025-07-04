<div class="flex gap-4 mb-4">
    <button 
        onclick="window.location.href='{{ route('perhiasan.muda.penjualan') }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.muda.penjualan') ? 'bg-secondary-300' : 'bg-perhiasan-muda hover:bg-secondary-300 active:bg-secondary-300' }}">
        Penjualan Muda
    </button>

    <button 
        onclick="window.location.href='{{ route('perhiasan.muda.pembelian') }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.muda.pembelian') ? 'bg-secondary-300' : 'bg-perhiasan-muda hover:bg-secondary-300 active:bg-secondary-300' }}">
        Pembelian Muda
    </button>

    <button 
        onclick="window.location.href='{{ route('perhiasan.muda.ringkasan') }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.muda.ringkasan') ? 'bg-secondary-300' : 'bg-perhiasan-muda hover:bg-secondary-300 active:bg-secondary-300' }}">
        Ringkasan
    </button>

    <button 
        onclick="window.location.href='{{ route('perhiasan.muda.gesek') }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.muda.gesek') ? 'bg-secondary-300' : 'bg-perhiasan-muda hover:bg-secondary-300 active:bg-secondary-300' }}">
        Gesek
    </button>

    <button 
        onclick="window.location.href='{{ route('perhiasan.muda.penjualanHarian',  ['id' => 1 ]) }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.muda.penjualanHarian') ? 'bg-secondary-300' : 'bg-perhiasan-muda hover:bg-secondary-300 active:bg-secondary-300' }}">
        Penjualan Harian
    </button>
</div>
