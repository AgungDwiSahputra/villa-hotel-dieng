<?php

namespace App\Http\Requests\JeepTrip;

use Illuminate\Foundation\Http\FormRequest;

class JeepTripImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->id;
        return [
            'jeep_trip_id' => ['required'],
            'judul' => ['nullable', 'string', 'max:150'],
            'image' => [$id ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'urutan' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes(): array
    {
        return [
            'jeep_trip_id' => 'paket jeep trip',
            'judul' => 'judul gambar',
            'image' => 'gambar',
            'urutan' => 'urutan',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Gambar wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
