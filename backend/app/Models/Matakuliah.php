<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matakuliah extends Model
{
    protected $table = 'matakuliah';

    protected $fillable = ['nama_mk'];

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'matakuliah_id');
    }
}
