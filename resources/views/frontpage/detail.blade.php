<x-home-layout :title="$product->name">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <a href="{{ route('katalog') }}" class="text-sm text-blue-700 hover:underline">&larr; Kembali ke katalog</a>

        <div class="grid md:grid-cols-2 gap-10 mt-6">
            <img src="{{ $product->img_url }}" alt="{{ $product->name }}" class="w-full rounded-2xl shadow bg-white object-cover aspect-square">

            <div>
                <p class="text-sm text-blue-700 font-medium">{{ $product->category->category ?? '-' }}</p>
                <h1 class="text-3xl font-bold mt-1">{{ $product->name }}</h1>
                <p class="text-2xl font-bold mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="mt-4 text-gray-600 leading-relaxed">{{ $product->description }}</p>
                <p class="mt-4 text-sm">
                    Stok:
                    @if ($product->stock > 0)
                        <span class="font-semibold">{{ $product->stock }} pasang</span>
                    @else
                        <span class="font-semibold text-red-600">Habis</span>
                    @endif
                </p>

                @if ($product->stock > 0)
                    <a href="{{ route('checkout', $product->slug) }}" class="inline-block mt-6 px-8 py-3 rounded-lg bg-blue-700 text-white font-medium hover:bg-blue-800">Beli Sekarang</a>
                @else
                    <button disabled class="mt-6 px-8 py-3 rounded-lg bg-gray-300 text-gray-600 cursor-not-allowed">Stok Habis</button>
                @endif
            </div>
        </div>

        @if ($related->count())
            <h2 class="text-xl font-bold mt-14 mb-4">Produk Serupa</h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach ($related as $product)
                    @include('frontpage.partials.card', ['product' => $product])
                @endforeach
            </div>
        @endif
    </div>
</x-home-layout>
