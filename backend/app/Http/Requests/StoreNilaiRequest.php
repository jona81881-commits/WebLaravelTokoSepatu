<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mahasiswa_id' => ['required', 'integer', 'exists:mahasiswa,id'],
            'matakuliah_id' => ['required', 'integer', 'exists:matakuliah,id'],
            'semester' => ['required', 'integer', 'between:1,14'],
            'nilai' => ['required', 'integer', 'between:0,100'],
        ];
    }
}
