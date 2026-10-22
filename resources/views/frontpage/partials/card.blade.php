<a href="{{ route('produk.detail', $product->slug) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
    <div class="relative aspect-square bg-gray-100 overflow-hidden">
        <img src="{{ $product->img_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        @if ($product->stock <= 0)
            <span class="absolute top-3 left-3 bg-gray-900 text-white text-xs px-2 py-1 rounded">Habis</span>
        @elseif ($product->stock <= 5)
            <span class="absolute top-3 left-3 bg-amber-500 text-white text-xs px-2 py-1 rounded">Sisa {{ $product->stock }}</span>
        @endif
    </div>
    <div class="p-4 flex-1 flex flex-col">
        <p class="text-xs text-blue-700 font-medium">{{ $product->category->category ?? '-' }}</p>
        <h3 class="font-semibold mt-1">{{ $product->name }}</h3>
        <p class="mt-auto pt-3 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
    </div>
</a>
