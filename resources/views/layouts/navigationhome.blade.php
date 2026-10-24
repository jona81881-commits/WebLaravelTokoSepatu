@php
    $link = fn ($active) => 'flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-[15px] text-white whitespace-nowrap transition '
        .($active ? 'bg-white/15' : 'hover:bg-white/10');
@endphp

<header class="sticky top-0 z-50 w-full text-white bg-brand-navy shadow-[0_6px_24px_rgba(40,53,131,0.25)]" x-data="{ open: false }">
    <div class="wrap flex items-center justify-between flex-wrap gap-3 py-3.5">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-white no-underline">
            <div class="flex items-center justify-center w-12 h-12 text-2xl rounded-[14px] bg-gradient-to-br from-brand-sky to-brand-blue shadow-[0_6px_16px_rgba(68,118,219,0.45)]">👟</div>
            <div>
                <div class="text-[22px] font-extrabold leading-[1.1] tracking-wide">Josepa</div>
                <div class="text-[11px] font-bold tracking-[0.14em] text-brand-sky mt-[3px]">TOKO SEPATU</div>
            </div>
        </a>

        <button class="md:hidden w-11 h-11 rounded-xl bg-white/15 text-xl" @click="open = !open" x-text="open ? '✕' : '☰'" aria-label="Menu"></button>

        <nav class="w-full md:w-auto" :class="open ? 'block' : 'hidden md:block'">
            <ul class="flex flex-col md:flex-row md:items-center gap-1 list-none p-0 m-0 pb-1.5 md:pb-0">
                <li>
                    <a href="{{ route('home') }}" class="{{ $link(request()->routeIs('home', 'katalog', 'produk.*', 'checkout', 'pesanan.*')) }}">
                        <svg class="ikon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('tentang') }}" class="{{ $link(request()->routeIs('tentang')) }}">
                        <svg class="ikon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/></svg>
                        Tentang
                    </a>
                </li>
                <li class="hidden md:block w-px h-7 mx-2.5 bg-white/20"></li>
                <li>
                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="{{ $link(false) }} bg-white/10 border border-white/30">
                                <svg class="ikon" viewBox="0 0 24 24"><path d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/></svg>
                                Admin
                            </a>
                        @else
                            <form action="{{ route('logout') }}" method="POST">@csrf
                                <button class="{{ $link(false) }} border border-white/30">Keluar</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="{{ $link(request()->routeIs('login')) }} bg-white/10 border border-white/30">
                            <svg class="ikon" viewBox="0 0 24 24"><path d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/></svg>
                            Admin
                        </a>
                    @endauth
                </li>
            </ul>
        </nav>
    </div>
</header>
