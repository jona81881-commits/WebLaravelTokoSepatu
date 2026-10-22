<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,product_id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
            'customer_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'phone' => ['required', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Nama penerima wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'quantity.min' => 'Jumlah minimal 1.',
        ];
    }
}
