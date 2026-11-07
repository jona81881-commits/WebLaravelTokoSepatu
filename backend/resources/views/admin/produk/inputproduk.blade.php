<x-admin-layout title="Input Produk">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-6 max-w-3xl">
        @csrf
        @include('admin.produk._form')
    </form>
</x-admin-layout>
