<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->id;
        return [
            'category_id' => ['required'],
            'name' => ['required','string','unique:produks,name,' . $id],
            'unit' => ['required','integer'],
            'kamar' => ['required','integer'],
            'orang' => ['required','integer'],
            'maks_orang' => ['required','integer'],
            'owner' => ['nullable','string'],
            'rating' => ['nullable','numeric','min:0','max:5'],
            'status' => ['required','in:publish,draft'],
            'harga_weekday' => ['required','integer'],
            'harga_weekend' => ['required','integer'],
            'label' => ['nullable','string'],
            'urutan' => ['required','integer'],
            'lokasi' => ['required','string'],
            'latitude' => ['nullable','numeric','between:-90,90'],
            'longitude' => ['nullable','numeric','between:-180,180'],
        ];
    }
}
