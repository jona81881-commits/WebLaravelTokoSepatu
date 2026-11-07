<x-home-layout title="Pembayaran">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-4 text-center">Pembayaran</h1>

        <div class="bg-white border border-brand-sky rounded-lg p-4 mb-6 flex gap-4 items-center">
            <img src="{{ $product->img_url }}" alt="{{ $product->name }}" class="w-24 h-24 object-contain mix-blend-multiply bg-brand-mist rounded-lg">
            <div>
                <h2 class="font-semibold">{{ $product->name }}</h2>
                <p class="text-sm text-gray-500">{{ $product->category->category ?? '' }} • Stok {{ $product->stock }}</p>
                <p class="text-brand-blue font-bold mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('pesan') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">

            @php($input = 'w-full border border-brand-sky rounded-lg p-3 bg-white outline-none focus:ring-2 focus:ring-brand-blue/40')

            <div>
                <label class="block font-medium mb-1">Nama penerima</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="{{ $input }}" required>
                @error('customer_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block font-medium mb-1">Nomor telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="{{ $input }}" required>
                @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block font-medium mb-1">Alamat lengkap</label>
                <textarea name="address" rows="3" class="{{ $input }}" required>{{ old('address') }}</textarea>
                @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block font-medium mb-1">Jumlah</label>
                <input type="number" name="quantity" min="1" max="{{ $product->stock }}" value="{{ old('quantity', 1) }}" class="{{ $input }} w-32" required>
                @error('quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                @error('product_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <button class="w-full py-2.5 bg-brand-blue text-white rounded-lg hover:bg-brand-navy transition">Buat Pesanan</button>
        </form>
    </div>
</x-home-layout>
