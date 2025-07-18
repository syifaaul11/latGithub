<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'shipping_address.required' => 'Alamat pengiriman harus diisi',
            'shipping_address.max' => 'Alamat pengiriman maksimal 500 karakter',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.max' => 'Nomor telepon maksimal 20 karakter',
            'notes.max' => 'Catatan maksimal 500 karakter',
            'items.required' => 'Minimal harus ada 1 produk',
            'items.array' => 'Format item tidak valid',
            'items.min' => 'Minimal harus ada 1 produk',
            'items.*.product_id.required' => 'ID produk harus diisi',
            'items.*.product_id.exists' => 'Produk tidak valid',
            'items.*.quantity.required' => 'Jumlah produk harus diisi',
            'items.*.quantity.integer' => 'Jumlah harus berupa angka bulat',
            'items.*.quantity.min' => 'Jumlah minimal 1',
        ];
    }
}