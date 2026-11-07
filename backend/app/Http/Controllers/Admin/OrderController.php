<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('product')
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->when($request->query('q'), fn ($q, $k) => $q->where(function ($w) use ($k) {
                $w->where('order_code', 'like', "%{$k}%")->orWhere('customer_name', 'like', "%{$k}%");
            }))
            ->orderByDesc('order_id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pesanan.daftarpesanan', compact('orders'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order, OrderService $orders)
    {
        $orders->updateStatus($order, $request->validated()['status']);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
