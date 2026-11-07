<x-home-layout title="Pesanan Berhasil">
    <div class="max-w-md mx-auto text-center bg-white border border-brand-sky rounded-xl p-8 shadow">
        <div class="text-5xl mb-2">✅</div>
        <h1 class="text-2xl font-bold mb-2">Pesanan Berhasil!</h1>
        <p class="text-gray-600">Terima kasih, {{ $order->customer_name }}.</p>
        <p class="mt-2">Nomor pesanan: <span class="font-semibold">{{ $order->order_code }}</span></p>

        <dl class="text-left text-sm mt-6 space-y-2 border-t border-brand-sky pt-4">
            <div class="flex justify-between"><dt>Produk</dt><dd>{{ $order->product->name }}</dd></div>
            <div class="flex justify-between"><dt>Jumlah</dt><dd>{{ $order->quantity }}</dd></div>
            <div class="flex justify-between"><dt>Total</dt><dd class="font-bold text-brand-blue">Rp {{ number_format($order->total_price, 0, ',', '.') }}</dd></div>
            <div class="flex justify-between"><dt>Status</dt><dd class="capitalize">{{ $order->status }}</dd></div>
        </dl>

        <a href="{{ route('home') }}" class="inline-block mt-6 px-5 py-2 bg-brand-blue text-white rounded-lg hover:bg-brand-navy">Kembali ke Beranda</a>
    </div>
</x-home-layout>
