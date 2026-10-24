<x-home-layout :title="$product->name">
    <div class="space-y-8">
        <a href="{{ route('home') }}" class="text-brand-blue hover:underline text-sm">← Kembali ke katalog</a>

        <div class="grid md:grid-cols-2 gap-8 bg-white border border-brand-sky rounded-xl p-6 shadow">
            <div class="h-72 md:h-96 bg-brand-mist rounded-lg overflow-hidden">
                <img src="{{ $product->img_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain mix-blend-multiply">
            </div>

            <div class="flex flex-col gap-3">
                <span class="text-xs bg-brand-sky/50 px-2 py-0.5 rounded-full w-fit">{{ $product->category->category ?? '-' }}</span>
                <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
                <p class="text-2xl text-brand-blue font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-gray-600">{{ $product->description }}</p>
                <p class="text-sm">
                    Stok:
                    @if ($product->stock > 0)
                        <span class="font-semibold">{{ $product->stock }} pasang</span>
                    @else
                        <span class="text-red-500 font-semibold">Habis</span>
                    @endif
                </p>

                <div class="flex gap-3 mt-2">
                    @if ($product->stock > 0)
                        <a href="{{ route('checkout', $product->slug) }}" class="px-5 py-2 rounded-lg text-white bg-brand-blue hover:bg-brand-navy transition">Beli Sekarang</a>
                    @else
                        <span class="px-5 py-2 rounded-lg text-white bg-gray-300 cursor-not-allowed">Stok Habis</span>
                    @endif
                </div>
            </div>
        </div>

        @if ($related->count())
            <div>
                <h2 class="text-xl font-semibold mb-4">Produk Serupa</h2>
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($related as $product)
                        @include('frontpage.partials.card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-home-layout>
