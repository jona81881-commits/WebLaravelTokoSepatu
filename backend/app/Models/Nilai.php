<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = ['mahasiswa_id', 'matakuliah_id', 'semester', 'nilai'];

    protected function casts(): array
    {
        return [
            'semester' => 'integer',
            'nilai' => 'integer',
        ];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }
}
