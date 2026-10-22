<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'img',
        'stock',
        'slug',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    /**
     * URL gambar (butuh `php artisan storage:link`).
     */
    public function getImgUrlAttribute(): string
    {
        return $this->img
            ? asset('storage/'.$this->img)
            : 'https://placehold.co/600x600/e5e7eb/6b7280?text=Josepa';
    }

    public function category(): BelongsTo
    {
        // setiap produk dimiliki oleh satu kategori
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'product_id', 'product_id');
    }

    /**
     * Pencarian dan penyaringan produk.
     * Parameter: q, category_id, min_price, max_price, in_stock, sort
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $keyword = trim((string) ($filters['q'] ?? ''));

        $query->when($keyword !== '', function (Builder $q) use ($keyword) {
            $q->where(function (Builder $w) use ($keyword) {
                $w->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('category', fn (Builder $c) => $c->where('category', 'like', "%{$keyword}%"));
            });
        });

        $query->when(! empty($filters['category_id']), fn (Builder $q) => $q->where('category_id', $filters['category_id']));

        $query->when(isset($filters['min_price']) && is_numeric($filters['min_price']), fn (Builder $q) => $q->where('price', '>=', $filters['min_price']));

        $query->when(isset($filters['max_price']) && is_numeric($filters['max_price']), fn (Builder $q) => $q->where('price', '<=', $filters['max_price']));

        $query->when(! empty($filters['in_stock']), fn (Builder $q) => $q->where('stock', '>', 0));

        match ($filters['sort'] ?? 'newest') {
            'price' => $query->orderBy('price'),
            '-price' => $query->orderByDesc('price'),
            'name' => $query->orderBy('name'),
            '-name' => $query->orderByDesc('name'),
            default => $query->orderByDesc('product_id'),
        };

        return $query;
    }

    /**
     * Membuat slug unik dari nama produk.
     */
    public static function makeSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn (Builder $q) => $q->where('product_id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
