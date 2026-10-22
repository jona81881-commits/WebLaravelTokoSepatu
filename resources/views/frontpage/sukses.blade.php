<x-home-layout title="Pesanan Berhasil">
    <div class="max-w-xl mx-auto px-4 py-16">
        <div class="bg-white rounded-2xl shadow p-8 text-center">
            <h1 class="text-2xl font-bold text-blue-700">Pesanan berhasil dibuat</h1>
            <p class="text-gray-600 mt-2">Simpan kode pesanan Anda:</p>
            <p class="text-3xl font-bold tracking-wider mt-3">{{ $order->order_code }}</p>

            <dl class="text-left text-sm mt-8 space-y-2 border-t pt-6">
                <div class="flex justify-between"><dt>Produk</dt><dd>{{ $order->product->name }}</dd></div>
                <div class="flex justify-between"><dt>Jumlah</dt><dd>{{ $order->quantity }}</dd></div>
                <div class="flex justify-between"><dt>Penerima</dt><dd>{{ $order->customer_name }}</dd></div>
                <div class="flex justify-between"><dt>Total</dt><dd class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between"><dt>Status</dt><dd class="capitalize">{{ $order->status }}</dd></div>
            </dl>

            <a href="{{ route('katalog') }}" class="inline-block mt-8 px-6 py-2.5 rounded-lg bg-blue-700 text-white hover:bg-blue-800">Belanja Lagi</a>
        </div>
    </div>
</x-home-layout>
