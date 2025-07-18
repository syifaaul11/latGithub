<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['name'] = 'required|string|max:255|unique:categories';
        } else {
            $rules['name'] = 'required|string|max:255|unique:categories,name,' . $this->category;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori harus diisi',
            'name.unique' => 'Nama kategori sudah ada',
            'name.max' => 'Nama kategori maksimal 255 karakter',
        ];
    }
}