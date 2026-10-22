<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderByDesc('product_id')->take(8)->get();
        $categories = Category::withCount('products')->get();

        return view('frontpage.landingpage', compact('products', 'categories'));
    }

    public function katalog(Request $request)
    {
        $products = Product::with('category')
            ->filter($request->only(['q', 'category_id', 'sort', 'in_stock', 'min_price', 'max_price']))
            ->paginate(8)
            ->withQueryString();

        $categories = Category::orderBy('category')->get();

        return view('frontpage.katalog', compact('products', 'categories'));
    }

    public function detail(Product $product)
    {
        $product->load('category');
        $related = Product::where('category_id', $product->category_id)
            ->where('product_id', '!=', $product->product_id)
            ->take(4)->get();

        return view('frontpage.detail', compact('product', 'related'));
    }

    public function checkout(Product $product)
    {
        return view('frontpage.checkout', compact('product'));
    }

    public function pesan(StoreOrderRequest $request, OrderService $orders)
    {
        $order = $orders->create($request->validated());

        return redirect()->route('pesanan.sukses', $order->order_code);
    }

    public function sukses(string $code)
    {
        $order = Order::with('product')->where('order_code', $code)->firstOrFail();

        return view('frontpage.sukses', compact('order'));
    }

    public function tentang()
    {
        return view('frontpage.tentang');
    }
}
