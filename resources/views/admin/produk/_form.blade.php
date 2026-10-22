@php($p = $product ?? null)

<div class="grid sm:grid-cols-2 gap-4">
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium mb-1">Nama sepatu</label>
        <input type="text" name="name" value="{{ old('name', $p?->name) }}" class="w-full border rounded-lg px-3 py-2" required>
        @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Kategori</label>
        <select name="category_id" class="w-full border rounded-lg px-3 py-2" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $c)
                <option value="{{ $c->category_id }}" @selected(old('category_id', $p?->category_id) == $c->category_id)>{{ $c->category }}</option>
            @endforeach
        </select>
        @error('category_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
        <input type="number" name="price" min="0" step="1" value="{{ old('price', $p ? (int) $p->price : '') }}" class="w-full border rounded-lg px-3 py-2" required>
        @error('price')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Stok</label>
        <input type="number" name="stock" min="0" value="{{ old('stock', $p?->stock) }}" class="w-full border rounded-lg px-3 py-2" required>
        @error('stock')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Gambar (jpg/png/webp, maks 2 MB)</label>
        <input type="file" name="img" accept="image/*" class="w-full border rounded-lg px-3 py-2 bg-white">
        @error('img')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        @if ($p && $p->img)
            <img src="{{ $p->img_url }}" alt="" class="w-20 h-20 rounded object-cover mt-2">
        @endif
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2">{{ old('description', $p?->description) }}</textarea>
        @error('description')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-6 py-2.5 rounded-lg bg-blue-700 text-white hover:bg-blue-800">Simpan</button>
    <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 rounded-lg border hover:bg-gray-100">Batal</a>
</div>
