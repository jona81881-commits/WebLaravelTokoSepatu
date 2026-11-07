<x-admin-layout title="Pesanan">
    <div class="bg-white rounded-xl shadow-sm">
        <form method="GET" class="p-4 border-b flex flex-wrap gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Kode / nama penerima" class="border rounded-lg px-3 py-2 text-sm">
            <select name="status" class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Semua status</option>
                @foreach (\App\Models\Order::STATUSES as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 rounded-lg bg-brand-blue text-white text-sm hover:bg-brand-navy">Cari</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-brand-navy text-left text-white">
                    <tr><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Penerima</th><th class="px-4 py-3">Produk</th><th class="px-4 py-3">Jml</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($orders as $o)
                        <tr class="border-t align-top">
                            <td class="px-4 py-3 font-mono">{{ $o->order_code }}</td>
                            <td class="px-4 py-3">{{ $o->customer_name }}<br><span class="text-xs text-gray-500">{{ $o->phone }}</span></td>
                            <td class="px-4 py-3">{{ $o->product->name }}</td>
                            <td class="px-4 py-3">{{ $o->quantity }}</td>
                            <td class="px-4 py-3">Rp {{ number_format($o->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.orders.status', $o) }}" class="flex gap-2">
                                    @csrf @method('PATCH')
                                    <select name="status" class="border rounded px-2 py-1">
                                        @foreach (\App\Models\Order::STATUSES as $s)
                                            <option value="{{ $s }}" @selected($o->status === $s)>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                    <button class="px-3 py-1 rounded bg-blue-100 text-blue-800 hover:bg-blue-200">Ubah</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t">{{ $orders->links() }}</div>
    </div>
</x-admin-layout>
