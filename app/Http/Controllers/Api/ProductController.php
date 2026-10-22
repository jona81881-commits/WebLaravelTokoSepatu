<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * GET /api/products?q=&category_id=&min_price=&max_price=&in_stock=1&sort=-price&per_page=8
     */
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 8), 1), 50);

        $products = Product::with('category')
            ->filter($request->only(['q', 'category_id', 'min_price', 'max_price', 'in_stock', 'sort']))
            ->paginate($perPage)
            ->withQueryString();

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['slug'] = Product::makeSlug($data['name']);

        $path = null;
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('products', 'public');
            $data['img'] = $path;
        }

        try {
            $product = DB::transaction(fn () => Product::create($data));
        } catch (\Throwable $e) {
            // jika gagal simpan, file yang terlanjur diunggah ikut dibersihkan
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            throw $e;
        }

        return (new ProductResource($product->load('category')))
            ->additional(['message' => 'Produk berhasil ditambahkan.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Gunakan POST + _method=PUT (form-data) bila ingin mengganti gambar,
     * karena PHP tidak membaca multipart pada request PUT asli.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if (isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = Product::makeSlug($data['name'], $product->product_id);
        }

        $oldImg = $product->img;
        $newPath = null;

        if ($request->hasFile('img')) {
            $newPath = $request->file('img')->store('products', 'public');
            $data['img'] = $newPath;
        } else {
            unset($data['img']);
        }

        try {
            DB::transaction(fn () => $product->update($data));
        } catch (\Throwable $e) {
            if ($newPath) {
                Storage::disk('public')->delete($newPath);
            }
            throw $e;
        }

        // gambar lama dihapus hanya setelah update berhasil
        if ($newPath && $oldImg) {
            Storage::disk('public')->delete($oldImg);
        }

        return (new ProductResource($product->fresh('category')))
            ->additional(['message' => 'Produk berhasil diperbarui.']);
    }

    public function destroy(Product $product): JsonResponse
    {
        if ($product->orders()->exists()) {
            return response()->json([
                'message' => 'Produk sudah memiliki pesanan dan tidak dapat dihapus.',
            ], 409);
        }

        DB::transaction(function () use ($product) {
            if ($product->img) {
                Storage::disk('public')->delete($product->img);
            }
            $product->delete();
        });

        return response()->json(['message' => 'Produk berhasil dihapus.']);
    }
}
