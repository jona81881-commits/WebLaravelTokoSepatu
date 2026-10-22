<x-admin-layout title="Dashboard">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([['Produk', $stats['produk']], ['Kategori', $stats['kategori']], ['Pesanan', $stats['pesanan']], ['Stok menipis (≤5)', $stats['stok_menipis']]] as [$l, $v])
            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-600">
                <p class="text-sm text-gray-500">{{ $l }}</p>
                <p class="text-3xl font-bold mt-1">{{ $v }}</p>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 mt-4">
        <p class="text-sm text-gray-500">Total pendapatan (tanpa pesanan batal)</p>
        <p class="text-2xl font-bold mt-1">Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm mt-6 overflow-x-auto">
        <div class="px-5 py-4 border-b font-semibold">Pesanan terbaru</div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr><th class="px-5 py-3">Kode</th><th class="px-5 py-3">Penerima</th><th class="px-5 py-3">Produk</th><th class="px-5 py-3">Total</th><th class="px-5 py-3">Status</th></tr>
            </thead>
            <tbody>
                @forelse ($latest as $o)
                    <tr class="border-t">
                        <td class="px-5 py-3 font-mono">{{ $o->order_code }}</td>
                        <td class="px-5 py-3">{{ $o->customer_name }}</td>
                        <td class="px-5 py-3">{{ $o->product->name }}</td>
                        <td class="px-5 py-3">Rp {{ number_format($o->total_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 capitalize">{{ $o->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-6 text-center text-gray-500">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
