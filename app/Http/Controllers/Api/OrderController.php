<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orders)
    {
    }

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

        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = $this->orders->create($request->validated());

        return (new OrderResource($order->load('product')))
            ->additional(['message' => 'Pesanan berhasil dibuat.'])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Order $order)
    {
        return new OrderResource($order->load('product'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $order = $this->orders->updateStatus($order, $request->validated()['status']);

        return new OrderResource($order->load('product'));
    }
}
