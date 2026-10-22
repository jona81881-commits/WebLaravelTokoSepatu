<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->filter($request->only(['q', 'category_id', 'sort']))
            ->paginate(8)
            ->withQueryString();

        $categories = Category::orderBy('category')->get();

        return view('admin.produk.daftarproduk', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('category')->get();

        return view('admin.produk.inputproduk', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Product::makeSlug($data['name']);

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('products', 'public');
        }

        DB::transaction(fn () => Product::create($data));

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('category')->get();

        return view('admin.produk.editproduk', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if (isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = Product::makeSlug($data['name'], $product->product_id);
        }

        $oldImg = $product->img;

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('products', 'public');
        } else {
            unset($data['img']);
        }

        DB::transaction(fn () => $product->update($data));

        if ($request->hasFile('img') && $oldImg) {
            Storage::disk('public')->delete($oldImg);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->orders()->exists()) {
            return back()->with('error', 'Produk sudah memiliki pesanan dan tidak dapat dihapus.');
        }

        DB::transaction(function () use ($product) {
            if ($product->img) {
                Storage::disk('public')->delete($product->img);
            }
            $product->delete();
        });

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
