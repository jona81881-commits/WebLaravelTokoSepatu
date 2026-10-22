<x-home-layout title="Beranda">
    {{-- Hero --}}
    <section class="relative bg-gray-900 text-white">
        <img src="{{ asset('images/hero-banner.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="relative max-w-6xl mx-auto px-4 py-24 sm:py-32">
            <p class="text-blue-300 font-medium mb-2">Toko Sepatu Josepa</p>
            <h1 class="text-4xl sm:text-5xl font-bold max-w-2xl leading-tight">Langkah nyaman untuk setiap hari</h1>
            <p class="mt-4 max-w-xl text-gray-200">Sepatu kets, lari, formal, kasual, dan bot dengan harga yang bersahabat.</p>
            <a href="{{ route('katalog') }}" class="inline-block mt-8 px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 font-medium">Lihat Katalog</a>
        </div>
    </section>

    {{-- Kategori --}}
    <section class="max-w-6xl mx-auto px-4 mt-12">
        <h2 class="text-2xl font-bold mb-6">Kategori</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach ($categories as $c)
                <a href="{{ route('katalog', ['category_id' => $c->category_id]) }}"
                   class="bg-white rounded-xl p-5 text-center shadow-sm hover:shadow-md hover:text-blue-700 transition">
                    <p class="font-semibold">{{ $c->category }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $c->products_count }} produk</p>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Produk terbaru --}}
    <section class="max-w-6xl mx-auto px-4 mt-12">
        <div class="flex items-end justify-between mb-6">
            <h2 class="text-2xl font-bold">Produk Terbaru</h2>
            <a href="{{ route('katalog') }}" class="text-sm text-blue-700 hover:underline">Lihat semua</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach ($products as $product)
                @include('frontpage.partials.card', ['product' => $product])
            @endforeach
        </div>
    </section>

    {{-- Keunggulan --}}
    <section class="max-w-6xl mx-auto px-4 mt-16 grid sm:grid-cols-3 gap-6 text-center">
        @foreach ([['Kualitas Terjaga', 'Setiap sepatu diperiksa sebelum dikirim.'], ['Pesan Mudah', 'Cukup isi data penerima, tanpa perlu membuat akun.'], ['Stok Real-time', 'Stok berkurang otomatis setiap ada pesanan.']] as [$t, $d])
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h3 class="font-semibold text-blue-700">{{ $t }}</h3>
                <p class="text-sm text-gray-600 mt-2">{{ $d }}</p>
            </div>
        @endforeach
    </section>
</x-home-layout>
