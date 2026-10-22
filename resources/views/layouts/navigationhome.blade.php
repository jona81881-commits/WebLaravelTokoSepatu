<nav class="bg-white border-b sticky top-0 z-40" x-data="{ open: false }">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-700 tracking-tight">Josepa</a>

        <div class="hidden md:flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">Beranda</a>
            <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog', 'produk.*') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">Katalog</a>
            <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }}">Tentang</a>
            @auth
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-700">Admin</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="px-4 py-1.5 rounded-lg border border-gray-300 hover:bg-gray-100">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-1.5 rounded-lg bg-blue-700 text-white hover:bg-blue-800">Masuk</a>
            @endauth
        </div>

        <button class="md:hidden p-2" @click="open = !open" aria-label="Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <div class="md:hidden border-t px-4 py-3 space-y-2 text-sm" x-show="open" x-cloak>
        <a class="block" href="{{ route('home') }}">Beranda</a>
        <a class="block" href="{{ route('katalog') }}">Katalog</a>
        <a class="block" href="{{ route('tentang') }}">Tentang</a>
        @auth
            @if (auth()->user()->is_admin)<a class="block" href="{{ route('admin.dashboard') }}">Admin</a>@endif
            <form action="{{ route('logout') }}" method="POST">@csrf<button>Keluar</button></form>
        @else
            <a class="block" href="{{ route('login') }}">Masuk</a>
        @endauth
    </div>
</nav>
