<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Admin Josepa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 antialiased" x-data="{ side: false }">
    @php
        $menu = [
            ['Dashboard', 'admin.dashboard', 'admin.dashboard'],
            ['Daftar Produk', 'admin.products.index', 'admin.products.index'],
            ['Input Produk', 'admin.products.create', 'admin.products.create'],
            ['Pesanan', 'admin.orders.index', 'admin.orders.*'],
        ];
    @endphp

    {{-- Sidebar biru --}}
    <aside class="fixed inset-y-0 left-0 w-64 bg-blue-800 text-blue-100 z-40 transform transition-transform md:translate-x-0"
           :class="side ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
        <div class="h-16 flex items-center px-6 text-white text-xl font-bold border-b border-blue-700">Josepa Admin</div>
        <nav class="p-4 space-y-1 text-sm">
            @foreach ($menu as [$label, $route, $pattern])
                <a href="{{ route($route) }}"
                   class="block px-4 py-2.5 rounded-lg {{ request()->routeIs($pattern) ? 'bg-blue-600 text-white' : 'hover:bg-blue-700' }}">
                    {{ $label }}
                </a>
            @endforeach
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-lg hover:bg-blue-700">Lihat Toko</a>
        </nav>
    </aside>

    <div class="md:ml-64 min-h-screen flex flex-col">
        <header class="h-16 bg-white border-b flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30">
            <button class="md:hidden p-2" @click="side = !side" aria-label="Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="font-semibold text-lg">{{ $title }}</h1>
            <div class="flex items-center gap-3 text-sm">
                <span class="hidden sm:inline text-gray-600">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="px-3 py-1.5 rounded-lg border hover:bg-gray-100">Keluar</button>
                </form>
            </div>
        </header>

        <main class="p-4 sm:p-6 flex-1">
            @if (session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 text-sm">{{ session('error') }}</div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
