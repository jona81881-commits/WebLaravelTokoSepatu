<x-admin-layout title="Daftar Produk">
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-4 border-b flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <form method="GET" class="flex flex-wrap gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..." class="border rounded-lg px-3 py-2 text-sm">
                <select name="category_id" class="border rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->category_id }}" @selected(request('category_id') == $c->category_id)>{{ $c->category }}</option>
                    @endforeach
                </select>
                <button class="px-4 py-2 rounded-lg bg-blue-700 text-white text-sm hover:bg-blue-800">Cari</button>
            </form>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 rounded-lg bg-blue-700 text-white text-sm text-center hover:bg-blue-800">+ Tambah Produk</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr><th class="px-4 py-3">#</th><th class="px-4 py-3">Gambar</th><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Harga</th><th class="px-4 py-3">Stok</th><th class="px-4 py-3 text-right">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($products as $p)
                        <tr class="border-t">
                            <td class="px-4 py-3">{{ $products->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3"><img src="{{ $p->img_url }}" alt="" class="w-12 h-12 rounded object-cover"></td>
                            <td class="px-4 py-3 font-medium">{{ $p->name }}</td>
                            <td class="px-4 py-3">{{ $p->category->category ?? '-' }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ $p->stock }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $p) }}" class="px-3 py-1 rounded bg-amber-100 text-amber-800 hover:bg-amber-200">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $p) }}" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1 rounded bg-red-100 text-red-800 hover:bg-red-200">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t">{{ $products->links() }}</div>
    </div>
</x-admin-layout>
