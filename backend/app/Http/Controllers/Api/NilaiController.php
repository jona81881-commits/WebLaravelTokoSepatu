<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNilaiRequest;
use App\Http\Resources\NilaiResource;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * GET /api/nilai?mahasiswa_id=1&semester=2
     */
    public function index(Request $request)
    {
        $nilai = Nilai::with(['mahasiswa', 'matakuliah'])
            ->when($request->query('mahasiswa_id'), fn ($q, $v) => $q->where('mahasiswa_id', $v))
            ->when($request->query('semester'), fn ($q, $v) => $q->where('semester', $v))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return NilaiResource::collection($nilai);
    }

    /**
     * GET /api/nilai/{id}
     */
    public function show(Nilai $nilai)
    {
        return new NilaiResource($nilai->load(['mahasiswa', 'matakuliah']));
    }

    /**
     * POST /api/nilai  (input nilai mahasiswa)
     */
    public function store(StoreNilaiRequest $request)
    {
        $nilai = Nilai::create($request->validated());

        return (new NilaiResource($nilai->load(['mahasiswa', 'matakuliah'])))
            ->additional(['message' => 'Nilai berhasil ditambahkan.'])
            ->response()
            ->setStatusCode(201);
    }
}
