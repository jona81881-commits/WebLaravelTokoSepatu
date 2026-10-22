<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    public const STATUSES = ['pending', 'dibayar', 'dikirim', 'selesai', 'dibatalkan'];

    protected $fillable = [
        'order_code',
        'product_id',
        'customer_name',
        'address',
        'phone',
        'quantity',
        'total_price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
