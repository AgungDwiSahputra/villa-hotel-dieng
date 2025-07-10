<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class ProdukImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->id;
        return [
            'produk_id' => ['required'],
            'name' => ['required','string','max:255'],
            'image' => [$id ? 'nullable' : 'required','image','mimes:jpeg,png,jpg,webp','max:2048'],
            'urutan' => ['required','integer'],
        ];
    }
}
