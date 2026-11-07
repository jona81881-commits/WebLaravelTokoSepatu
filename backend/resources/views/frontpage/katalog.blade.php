<x-home-layout title="Katalog">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-6">Katalog Sepatu</h1>

        <form method="GET" class="bg-white rounded-xl shadow-sm p-4 grid gap-3 sm:grid-cols-5 mb-8">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari sepatu..."
                   class="sm:col-span-2 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            <select name="category_id" class="border rounded-lg px-3 py-2">
                <option value="">Semua kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->category_id }}" @selected(request('category_id') == $c->category_id)>{{ $c->category }}</option>
                @endforeach
            </select>
            <select name="sort" class="border rounded-lg px-3 py-2">
                <option value="">Terbaru</option>
                <option value="price" @selected(request('sort') === 'price')>Harga terendah</option>
                <option value="-price" @selected(request('sort') === '-price')>Harga tertinggi</option>
                <option value="name" @selected(request('sort') === 'name')>Nama A-Z</option>
            </select>
            <button class="rounded-lg bg-blue-700 text-white px-4 py-2 hover:bg-blue-800">Cari</button>
        </form>

        @if ($products->count())
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach ($products as $product)
                    @include('frontpage.partials.card', ['product' => $product])
                @endforeach
            </div>
            <div class="mt-8">{{ $products->links() }}</div>
        @else
            <p class="text-center text-gray-500 py-16">Sepatu yang Anda cari tidak ditemukan.</p>
        @endif
    </div>
</x-home-layout>
