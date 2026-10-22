<x-admin-layout title="Edit Produk">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
        @csrf @method('PUT')
        @include('admin.produk._form')
    </form>
</x-admin-layout>
