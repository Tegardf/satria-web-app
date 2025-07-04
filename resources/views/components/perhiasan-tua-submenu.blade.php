<div class="flex gap-4 mb-4">
    <button 
        onclick="window.location.href='{{ route('perhiasan.tua.penjualan') }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.tua.penjualan') ? 'bg-secondary-300' : 'bg-perhiasan-tua hover:bg-secondary-300 active:bg-secondary-300' }}">
        Penjualan Tua
    </button>

    <button 
        onclick="window.location.href='{{ route('perhiasan.tua.pembelian') }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.tua.pembelian') ? 'bg-secondary-300' : 'bg-perhiasan-tua hover:bg-secondary-300 active:bg-secondary-300' }}">
        Pembelian Tua
    </button>

    <button 
        onclick="window.location.href='{{ route('perhiasan.tua.ringkasan') }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.tua.ringkasan') ? 'bg-secondary-300' : 'bg-perhiasan-tua hover:bg-secondary-300 active:bg-secondary-300' }}">
        Ringkasan
    </button>

    <button 
        onclick="window.location.href='{{ route('perhiasan.tua.gesek') }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.tua.gesek') ? 'bg-secondary-300' : 'bg-perhiasan-tua hover:bg-secondary-300 active:bg-secondary-300' }}">
        Gesek
    </button>

    <button 
        onclick="window.location.href='{{ route('perhiasan.tua.penjualanHarian',  ['id' => 1 ]) }}'" 
        class="text-center w-full text-secondary-800 ring-secondary-800 ring-2 text-xl font-bold py-4 rounded-xl 
               {{ request()->routeIs('perhiasan.tua.penjualanHarian') ? 'bg-secondary-300' : 'bg-perhiasan-tua hover:bg-secondary-300 active:bg-secondary-300' }}">
        Penjualan Harian
    </button>
</div>
