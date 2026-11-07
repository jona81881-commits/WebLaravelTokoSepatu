@php
    $soldOut = $product->stock <= 0;
    $lowStock = $product->stock > 0 && $product->stock <= 8;
@endphp

<div class="card-hover fade-in group bg-white rounded-[20px] overflow-hidden flex flex-col border border-brand-sky/40 shadow-[0_8px_28px_rgba(40,53,131,0.08)] hover:shadow-[0_18px_44px_rgba(40,53,131,0.18)]">
    <a href="{{ route('produk.detail', $product->slug) }}" class="relative block aspect-[4/3] bg-gradient-to-br from-brand-mist/70 to-white p-6 overflow-hidden">
        <img src="{{ $product->img_url }}" alt="{{ $product->name }}"
             class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
        <span class="absolute top-4 left-4 text-[11px] font-bold tracking-wider uppercase bg-brand-navy text-white px-3.5 py-1.5 rounded-full shadow-md">
            {{ $product->category->category ?? '-' }}
        </span>
        @if ($soldOut)
            <span class="absolute top-4 right-4 bg-red-500 text-white text-[11px] font-bold px-3 py-1.5 rounded-full shadow-md">Stok Habis</span>
        @elseif ($lowStock)
            <span class="absolute top-4 right-4 bg-amber-400 text-white text-[11px] font-bold px-3 py-1.5 rounded-full shadow-md">Stok Tinggal {{ $product->stock }}</span>
        @endif
    </a>

    <div class="p-5 flex flex-col flex-1">
        <h2 class="font-bold text-lg text-brand-navy leading-snug">{{ $product->name }}</h2>
        <p class="text-brand-blue font-extrabold text-xl mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

        <div class="mt-auto pt-4 flex gap-2">
            <a href="{{ route('produk.detail', $product->slug) }}" class="px-4 py-2.5 rounded-xl border border-brand-sky text-brand-navy text-sm font-semibold hover:bg-brand-mist transition">Detail</a>
            @if ($soldOut)
                <span class="flex-1 text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gray-300 cursor-not-allowed">Tidak Tersedia</span>
            @else
                <a href="{{ route('checkout', $product->slug) }}" class="flex-1 text-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-blue hover:bg-brand-navy transition">Beli Sekarang</a>
            @endif
        </div>
    </div>
</div>
