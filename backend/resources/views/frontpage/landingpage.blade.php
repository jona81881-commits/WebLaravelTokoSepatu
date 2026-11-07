<x-home-layout title="Beranda">
    {{-- Filter bar --}}
    <x-slot:filter>
    <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="relative w-full md:w-1/2">
            <svg class="ikon absolute left-4 top-1/2 -translate-y-1/2 text-brand-blue" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari sepatu kets, lari, formal, bot..."
                   class="w-full pl-12 pr-4 py-3 rounded-xl bg-white text-sm border border-brand-sky/70 outline-none focus:ring-2 focus:ring-brand-blue/40">
        </div>
        <div class="flex items-center gap-3">
            <span class="hidden md:flex items-center gap-2 text-sm font-bold uppercase tracking-wide">
                <svg class="ikon text-brand-blue" viewBox="0 0 24 24"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                Kategori:
            </span>
            <select name="category_id" onchange="this.form.submit()"
                    class="w-full md:w-auto px-4 py-3 rounded-xl bg-white text-sm font-semibold border border-brand-sky/70 outline-none focus:ring-2 focus:ring-brand-blue/40">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->category_id }}" @selected(request('category_id') == $c->category_id)>{{ $c->category }}</option>
                @endforeach
            </select>
        </div>
    </form>
    </x-slot:filter>

    {{-- Hero --}}
    <section class="rounded-3xl text-white mb-10 min-h-[200px] flex flex-col justify-center px-6 md:px-10 py-7 bg-cover bg-center shadow-[0_18px_40px_rgba(40,53,131,0.22)]"
             style="background-image: linear-gradient(100deg, rgba(40,53,131,.96) 0%, rgba(40,53,131,.82) 45%, rgba(68,118,219,.55) 100%), url('{{ asset('assets/images/hero-banner.jpg') }}')">
        <span class="w-fit flex items-center gap-2 text-xs font-semibold bg-white/10 border border-white/25 px-3.5 py-1.5 rounded-full mb-3">
            <svg class="ikon" viewBox="0 0 24 24"><path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3z"/></svg>
            Koleksi Sepatu 2026
        </span>
        <h1 class="text-2xl md:text-4xl font-extrabold tracking-tight leading-tight max-w-3xl">Langkah Terbaikmu Dimulai di Sini.</h1>
        <p class="mt-2 text-white/85 text-sm md:text-base max-w-xl">
            Koleksi sepatu kets, lari, formal, kasual, dan bot dengan harga bersahabat. Klik detail untuk informasi lengkap atau langsung beli.
        </p>
    </section>

    {{-- Katalog --}}
    <div id="katalog" class="mb-6 pb-4 border-b border-brand-sky/50 scroll-mt-28">
        <h2 class="text-3xl font-extrabold tracking-tight">Katalog Produk</h2>
        <p class="mt-1 text-sm text-slate-500">
            Kategori:
            <span class="font-bold text-brand-blue">{{ $activeCategory->category ?? 'Semua Kategori' }}</span>
            • Menampilkan <span class="font-bold text-brand-blue">{{ $products->total() }}</span> produk
        </p>
    </div>

    @if ($products->count())
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                @include('frontpage.partials.card', ['product' => $product])
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    @else
        <p class="text-gray-500">Sepatu yang kamu cari tidak ditemukan.</p>
    @endif
</x-home-layout>
