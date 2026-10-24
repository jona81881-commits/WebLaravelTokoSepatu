<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Admin Josepa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { brand: { navy: '#283583', blue: '#4476DB', sky: '#9ACDE0', mist: '#D3E8E6' } } } }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <style>
        body { margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; color: #283583; }
        [x-cloak] { display: none !important; }
        nav[role="navigation"] svg { width: 20px; height: 20px; display: inline; }
    </style>
</head>
<body class="antialiased" x-data="{ side: false }">
    @php
        $menu = [
            ['Dasbor', 'admin.dashboard', 'admin.dashboard'],
            ['Daftar Produk', 'admin.products.index', 'admin.products.index'],
            ['Input Produk', 'admin.products.create', 'admin.products.create'],
            ['Pesanan', 'admin.orders.index', 'admin.orders.*'],
        ];
    @endphp

    {{-- Header --}}
    <div class="bg-brand-navy text-white">
        <div class="max-w-[1600px] mx-auto flex items-center justify-between px-4 py-5">
            <h1 class="text-2xl font-bold">Admin Josepa</h1>
            <div class="flex items-center gap-4 text-sm">
                <button class="md:hidden border border-white px-3 py-1" @click="side = !side">☰</button>
                <a href="{{ route('home') }}" class="hover:text-brand-sky hover:underline">Lihat Toko</a>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button class="hover:text-brand-sky hover:underline">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-[1600px] mx-auto">
        <div class="bg-brand-mist md:flex min-h-[450px]">
            {{-- Sidebar --}}
            <aside class="bg-brand-navy md:w-1/4 md:min-h-[450px]" :class="side ? 'block' : 'hidden md:block'">
                <ul class="list-none p-0 m-0">
                    @foreach ($menu as [$label, $route, $pattern])
                        <li>
                            <a href="{{ route($route) }}" class="block text-white no-underline px-4 py-3 hover:bg-brand-blue {{ request()->routeIs($pattern) ? 'bg-brand-blue' : '' }}">{{ $label }}</a>
                        </li>
                    @endforeach
                    <li><a href="{{ route('home') }}" class="block text-white no-underline px-4 py-3 hover:bg-brand-blue">← Kembali ke Toko</a></li>
                </ul>
            </aside>

            {{-- Konten --}}
            <main class="bg-white md:w-3/4 p-6">
                <h2 class="text-2xl font-bold mb-4">{{ $title }}</h2>

                @if (session('success'))
                    <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 text-sm">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 text-sm">{{ session('error') }}</div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    <div class="bg-brand-navy text-white text-center p-4 text-sm">
        <p>© 2026 Admin Josepa — v1.0.0</p>
    </div>
</body>
</html>
