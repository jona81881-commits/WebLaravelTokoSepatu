<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // primary key bukan 'id'
    protected $primaryKey = 'category_id';

    // field yang boleh diisi massal
    protected $fillable = ['category'];

    public function products(): HasMany
    {
        // satu kategori memiliki banyak produk
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
