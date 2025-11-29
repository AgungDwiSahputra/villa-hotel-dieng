<?php

namespace App\Http\Requests\JeepTrip;

use Illuminate\Foundation\Http\FormRequest;

class JeepTripAvailabilityRequest extends FormRequest
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
        $id = $this->route('availability') ?? $this->id;

        return [
            'jeep_trip_slot_id' => ['required', 'string', 'exists:jeep_trip_slots,id'],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'quota_jeep' => ['required', 'integer', 'min:1', 'max:50'],
            'is_closed' => ['boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'jeep_trip_slot_id' => 'slot jeep trip',
            'tanggal' => 'tanggal',
            'quota_jeep' => 'quota jeep',
            'is_closed' => 'status tutup',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'jeep_trip_slot_id.required' => 'Slot jeep trip wajib dipilih.',
            'jeep_trip_slot_id.exists' => 'Slot jeep trip yang dipilih tidak valid.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal harus hari ini atau setelahnya.',
            'quota_jeep.required' => 'Quota jeep wajib diisi.',
            'quota_jeep.min' => 'Quota jeep minimal 1.',
            'quota_jeep.max' => 'Quota jeep maksimal 50.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure boolean fields are properly cast
        $this->merge([
            'is_closed' => $this->boolean('is_closed', false),
        ]);
    }
}