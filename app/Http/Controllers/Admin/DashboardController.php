<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'produk' => Product::count(),
            'kategori' => Category::count(),
            'pesanan' => Order::count(),
            'pendapatan' => Order::where('status', '!=', 'dibatalkan')->sum('total_price'),
            'stok_menipis' => Product::where('stock', '<=', 5)->count(),
        ];

        $latest = Order::with('product')->orderByDesc('order_id')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latest'));
    }
}
