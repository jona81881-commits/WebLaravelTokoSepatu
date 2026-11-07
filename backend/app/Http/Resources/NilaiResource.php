<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NilaiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mahasiswa' => [
                'id' => $this->mahasiswa_id,
                'nama' => $this->mahasiswa?->nama,
                'nim' => $this->mahasiswa?->nim,
            ],
            'matakuliah' => [
                'id' => $this->matakuliah_id,
                'nama_mk' => $this->matakuliah?->nama_mk,
            ],
            'semester' => $this->semester,
            'nilai' => $this->nilai,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
