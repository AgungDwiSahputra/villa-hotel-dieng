<?php

namespace App\Http\Requests\JeepTrip;

use Illuminate\Foundation\Http\FormRequest;

class JeepTripRequest extends FormRequest
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
        $id = $this->route('jeep_trip') ?? $this->id;

        return [
            // Basic Jeep Trip fields
            'kode' => ['nullable', 'string', 'max:50', 'unique:jeep_trips,kode,' . $id],
            'nama_paket' => ['required', 'string', 'max:150'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'zona' => ['nullable', 'string', 'max:50'],
            'durasi_jam' => ['nullable', 'integer', 'min:1', 'max:24'],
            'kapasitas_ideal_per_jeep' => ['required', 'integer', 'min:1', 'max:10'],
            'kapasitas_max_per_jeep' => ['required', 'integer', 'min:1', 'max:10', 'gte:kapasitas_ideal_per_jeep'],
            'harga_weekday' => ['required', 'numeric', 'min:0'],
            'harga_weekend' => ['required', 'numeric', 'min:0'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'is_active' => ['boolean'],

            // Destinations (array validation)
            'destinations' => ['nullable', 'array'],
            'destinations.*.nama_destinasi' => ['required_with:destinations', 'string', 'max:150'],

            // Includes (array validation)
            'includes' => ['nullable', 'array'],
            'includes.*.nama_item' => ['required_with:includes', 'string', 'max:150'],

            // Excludes (array validation)
            'excludes' => ['nullable', 'array'],
            'excludes.*.nama_item' => ['required_with:excludes', 'string', 'max:150'],

            // Images (file validation)
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // 2MB max

            // Slots (array validation)
            'slots' => ['nullable', 'array'],
            'slots.*.nama_slot' => ['required_with:slots', 'string', 'max:100'],
            'slots.*.jam_mulai' => ['required_with:slots', 'date_format:H:i'],
            'slots.*.jam_selesai' => ['required_with:slots', 'date_format:H:i'],
            'slots.*.is_active' => ['boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_paket' => 'nama paket',
            'deskripsi_singkat' => 'deskripsi singkat',
            'deskripsi_lengkap' => 'deskripsi lengkap',
            'durasi_jam' => 'durasi (jam)',
            'kapasitas_ideal_per_jeep' => 'kapasitas ideal per jeep',
            'kapasitas_max_per_jeep' => 'kapasitas maksimal per jeep',
            'harga_weekday' => 'harga weekday',
            'harga_weekend' => 'harga weekend',
            'destinations.*.nama_destinasi' => 'nama destinasi',
            'includes.*.nama_item' => 'item include',
            'excludes.*.nama_item' => 'item exclude',
            'slots.*.nama_slot' => 'nama slot',
            'slots.*.jam_mulai' => 'jam mulai',
            'slots.*.jam_selesai' => 'jam selesai',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_paket.required' => 'Nama paket wajib diisi.',
            'kapasitas_ideal_per_jeep.required' => 'Kapasitas ideal per jeep wajib diisi.',
            'kapasitas_max_per_jeep.required' => 'Kapasitas maksimal per jeep wajib diisi.',
            'kapasitas_max_per_jeep.gte' => 'Kapasitas maksimal harus lebih besar atau sama dengan kapasitas ideal.',
            'harga_weekday.required' => 'Harga weekday wajib diisi.',
            'harga_weekend.required' => 'Harga weekend wajib diisi.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure boolean fields are properly cast
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);

        // Prepare slots array with boolean casting
        if ($this->has('slots') && is_array($this->slots)) {
            $slots = [];
            foreach ($this->slots as $slot) {
                $slots[] = [
                    'nama_slot' => $slot['nama_slot'] ?? null,
                    'jam_mulai' => $slot['jam_mulai'] ?? null,
                    'jam_selesai' => $slot['jam_selesai'] ?? null,
                    'is_active' => isset($slot['is_active']) ? (bool) $slot['is_active'] : true,
                ];
            }
            $this->merge(['slots' => $slots]);
        }
    }
}