<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body {{ $attributes->merge([ 'class'=>"font-sans antialiased"])}}>
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-80 bg-primary-700 h-screen sticky top-0 rounded-e-3xl">
            <div class="p-6 ">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('logo.svg') }}" alt="Logo" class="w-36 h-36 mx-auto">
                </a>
            </div>

            <!-- Sidebar navigation -->
            <nav class="ps-4 py-4">
                <a href="{{ route('dashboard') }}" class="flex flex-col group ">
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-ee-full {{ Route::is('dashboard') ? 'rounded-ee-full' : '' }}"></div>
                    </div>
                    <div class="flex flex-row justify-start ps-4 py-2 rounded-s-3xl items-center gap-3 group-hover:bg-neutral-400 group-hover:text-neutral-900  text-neutral-200 {{ Route::is('dashboard') ? 'bg-neutral-400 text-neutral-900' : '' }}">
                        <img src="{{ asset('dashboard.svg') }}" alt="" class="w-9 h-9"> 
                        <h1 class="text-xl ">Dashboard</h1>
                    </div>
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-se-full {{ Route::is('dashboard') ? 'rounded-se-full' : '' }}"></div>
                    </div>
                </a>
                <a href="{{ route('perhiasan.tua.') }}" class="flex flex-col group ">
                    <div class="bg-perhiasan-tua h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-ee-full {{ Route::is('perhiasan.tua.*') ? 'rounded-ee-full' : '' }}"></div>
                    </div>
                    <div class="flex flex-row justify-start ps-4 py-2 rounded-s-3xl items-center gap-3 group-hover:bg-perhiasan-tua group-hover:text-neutral-900  text-neutral-200 {{ Route::is('perhiasan.tua.*') ? 'bg-perhiasan-tua text-neutral-900' : '' }}">
                        <img src="{{ asset('perhiasan-tua.svg') }}" alt="" class="w-9 h-9"> 
                        <h1 class="text-xl ">Perhiasan Tua</h1>
                    </div>
                    <div class="bg-perhiasan-tua h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-se-full {{ Route::is('perhiasan.tua.*') ? 'rounded-se-full' : '' }}"></div>
                    </div>
                </a>
                <a href="{{ route('perhiasan.muda.') }}" class="flex flex-col group ">
                    <div class="bg-perhiasan-muda h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-ee-full {{ Route::is('perhiasan.muda.*') ? 'rounded-ee-full' : '' }}"></div>
                    </div>
                    <div class="flex flex-row justify-start ps-4 py-2 rounded-s-3xl items-center gap-3 group-hover:bg-perhiasan-muda group-hover:text-neutral-900  text-neutral-200 {{ Route::is('perhiasan.muda.*') ? 'bg-perhiasan-muda text-neutral-900' : '' }}">
                        <img src="{{ asset('perhiasan-muda.svg') }}" alt="" class="w-9 h-9"> 
                        <h1 class="text-xl ">Perhiasan Muda</h1>
                    </div>
                    <div class="bg-perhiasan-muda h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-se-full {{ Route::is('perhiasan.muda.*') ? 'rounded-se-full' : '' }}"></div>
                    </div>
                </a>
                <a href="{{ route('input.produk', ['perhiasan_id' => 1, 'produk_id' => 1])}}" class="flex flex-col group ">
                    <div class="{{request('perhiasan_id') == 1 ? 'bg-perhiasan-tua' : 'bg-perhiasan-muda'}} h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-ee-full {{ Route::is('input.produk') ? 'rounded-ee-full' : '' }}"></div>
                    </div>
                    <div class="flex flex-row justify-start ps-4 py-2 rounded-s-3xl items-center gap-3 {{request('perhiasan_id') == 2 ? 'group-hover:bg-perhiasan-muda' : 'group-hover:bg-perhiasan-tua'}}  group-hover:text-neutral-900  text-neutral-200 {{ Route::is('input.produk') ? (request('perhiasan_id') == 1 ? 'bg-perhiasan-tua text-neutral-900' : 'bg-perhiasan-muda text-neutral-900') : '' }}">
                        <img src="{{ asset('input-produk.svg') }}" alt="" class="w-9 h-9"> 
                        <h1 class="text-xl ">Input Produk</h1>
                    </div>
                    <div class="{{request('perhiasan_id') == 1 ? 'bg-perhiasan-tua' : 'bg-perhiasan-muda'}} h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-se-full {{ Route::is('input.produk') ? 'rounded-se-full' : '' }}"></div>
                    </div>
                </a>
                <a href="{{ route('persenan', ['idTua' => 1, 'idMuda' => 1, 'idTotal' => 1]) }}" class="flex flex-col group ">
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-ee-full {{ Route::is('persenan') ? 'rounded-ee-full' : '' }}"></div>
                    </div>
                    <div class="flex flex-row justify-start ps-4 py-2 rounded-s-3xl items-center gap-3 group-hover:bg-neutral-400 group-hover:text-neutral-900  text-neutral-200 {{ Route::is('persenan') ? 'bg-neutral-400 text-neutral-900' : '' }}">
                        <img src="{{ asset('persenan.svg') }}" alt="" class="w-9 h-9"> 
                        <h1 class="text-xl ">Persenan</h1>
                    </div>
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-se-full {{ Route::is('persenan') ? 'rounded-se-full' : '' }}"></div>
                    </div>
                </a>
                
                <a href="{{ route('restock.produk') }}" class="flex flex-col group ">
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-ee-full {{ Route::is('restock.produk') ? 'rounded-ee-full' : '' }}"></div>
                    </div>
                    <div class="flex flex-row justify-start ps-4 py-2 rounded-s-3xl items-center gap-3 group-hover:bg-neutral-400 group-hover:text-neutral-900  text-neutral-200 {{ Route::is('restock.produk') ? 'bg-neutral-400 text-neutral-900' : '' }}">
                        <img src="{{ asset('restock.svg') }}" alt="" class="w-9 h-9"> 
                        <h1 class="text-xl ">Restock Produk</h1>
                    </div>
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-se-full {{ Route::is('restock.produk') ? 'rounded-se-full' : '' }}"></div>
                    </div>
                </a>
                
                
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 mb-4 ps-4 w-full">
                <a href="{{ route('profile.edit') }}" class="flex flex-col group ">
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-ee-full {{ Route::is('profile.edit') ? 'rounded-ee-full' : '' }}"></div>
                    </div>
                    <div class="flex flex-row justify-start ps-4 py-2 rounded-s-3xl items-center gap-3 group-hover:bg-neutral-400 group-hover:text-neutral-900  text-neutral-200 {{ Route::is('profile.edit') ? 'bg-neutral-400 text-neutral-900' : '' }}">
                        <img src="{{ asset('setting.svg') }}" alt="" class="w-9 h-9"> 
                        <h1 class="text-xl ">Settings</h1>
                    </div>
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-se-full {{ Route::is('profile.edit') ? 'rounded-se-full' : '' }}"></div>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex flex-col group ">
                    @csrf

                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-ee-full {{ Route::is('logout') ? 'rounded-ee-full' : '' }}"></div>
                    </div>
                    <button type="submit" class="flex flex-row justify-start ps-4 py-2 rounded-none rounded-s-3xl items-center gap-3 group-hover:bg-neutral-400 group-hover:text-neutral-900  text-neutral-200 {{ Route::is('logout') ? 'bg-neutral-400 text-neutral-900' : '' }}">
                        <img src="{{ asset('logout.svg') }}" alt="" class="w-9 h-9"> 
                        <h1 class="text-xl ">Logout</h1>
                    </button>
                    <div class="bg-neutral-400 h-3 w-full">
                        <div class="bg-primary-700 h-3 w-full group-hover:rounded-se-full {{ Route::is('logout') ? 'rounded-se-full' : '' }}"></div>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            @isset($header)
                <header class="mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $header }}</h2>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>