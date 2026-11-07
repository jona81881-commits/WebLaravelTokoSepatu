<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderService
{
    /**
     * Membuat pesanan dengan aman: seluruh langkah berada dalam satu transaksi.
     * Baris produk dikunci (lockForUpdate) agar stok tidak bisa terjual melebihi
     * jumlah yang tersedia saat ada dua pesanan bersamaan.
     */
    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            if ($product->stock < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => "Stok {$product->name} tidak mencukupi (tersisa {$product->stock}).",
                ]);
            }

            $product->decrement('stock', $data['quantity']);

            return Order::create([
                'order_code' => 'JSP-'.strtoupper(Str::random(8)),
                'product_id' => $product->product_id,
                'customer_name' => $data['customer_name'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'quantity' => $data['quantity'],
                'total_price' => $product->price * $data['quantity'],
                'status' => 'pending',
            ]);
        });
    }

    /**
     * Mengubah status. Jika dibatalkan, stok dikembalikan (juga dalam transaksi).
     */
    public function updateStatus(Order $order, string $status): Order
    {
        return DB::transaction(function () use ($order, $status) {
            $order = Order::lockForUpdate()->findOrFail($order->order_id);

            if ($status === 'dibatalkan' && $order->status !== 'dibatalkan') {
                Product::whereKey($order->product_id)->increment('stock', $order->quantity);
            }

            $order->update(['status' => $status]);

            return $order;
        });
    }
}
