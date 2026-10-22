<x-home-layout title="Checkout">
    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-6">Checkout</h1>

        <div class="grid md:grid-cols-5 gap-8">
            <form method="POST" action="{{ route('pesan') }}" class="md:col-span-3 bg-white rounded-2xl shadow-sm p-6 space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                @foreach ([['customer_name', 'Nama penerima', 'text'], ['phone', 'Nomor telepon', 'text']] as [$f, $l, $t])
                    <div>
                        <label class="block text-sm font-medium mb-1">{{ $l }}</label>
                        <input type="{{ $t }}" name="{{ $f }}" value="{{ old($f) }}" required
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        @error($f)<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                @endforeach

                <div>
                    <label class="block text-sm font-medium mb-1">Alamat lengkap</label>
                    <textarea name="address" rows="3" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('address') }}</textarea>
                    @error('address')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Jumlah</label>
                    <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="{{ old('quantity', 1) }}" required
                           class="w-28 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('quantity')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                    @error('product_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <button class="w-full py-3 rounded-lg bg-blue-700 text-white font-medium hover:bg-blue-800">Buat Pesanan</button>
            </form>

            <aside class="md:col-span-2 bg-white rounded-2xl shadow-sm p-6 h-fit">
                <img src="{{ $product->img_url }}" alt="{{ $product->name }}" class="w-full rounded-xl aspect-square object-cover">
                <h2 class="font-semibold mt-4">{{ $product->name }}</h2>
                <p class="text-sm text-gray-500">{{ $product->category->category ?? '' }}</p>
                <p class="font-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">Stok tersedia: {{ $product->stock }}</p>
            </aside>
        </div>
    </div>
</x-home-layout>
