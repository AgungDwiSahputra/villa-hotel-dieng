<?php

namespace App\Http\Requests\Landing;

use Illuminate\Foundation\Http\FormRequest;

class ProdukFinalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produk_id'  => ['required', 'uuid', 'exists:produks,id'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'night'      => ['required', 'integer', 'min:1'],
            'unit'       => ['required', 'integer', 'min:1'],
            'dp'         => ['required', 'numeric', 'min:0'],
            'total'      => ['required', 'numeric', 'min:0'],
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'no_wa'      => ['required', 'string', 'max:20'],
            // 'image'      => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'produk_id.required'      => 'Produk harus dipilih.',
            'produk_id.uuid'          => 'Format produk tidak valid.',
            'produk_id.exists'        => 'Produk yang dipilih tidak tersedia.',

            'start_date.required'     => 'Tanggal mulai harus diisi.',
            'start_date.date'         => 'Format tanggal mulai tidak valid.',
            'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal selesai.',

            'end_date.required'       => 'Tanggal selesai harus diisi.',
            'end_date.date'           => 'Format tanggal selesai tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',

            'night.required'          => 'Jumlah malam harus diisi.',
            'night.integer'           => 'Jumlah malam harus berupa angka bulat.',
            'night.min'               => 'Jumlah malam minimal 1.',

            'unit.required'           => 'Jumlah unit harus diisi.',
            'unit.integer'            => 'Jumlah unit harus berupa angka bulat.',
            'unit.min'                => 'Jumlah unit minimal 1.',

            'total.required'          => 'Total harus diisi.',
            'total.numeric'           => 'Total harus berupa angka.',
            'total.min'               => 'Total tidak boleh kurang dari 0.',

            'name.required'           => 'Nama harus diisi.',
            'name.string'             => 'Nama harus berupa teks.',
            'name.max'                => 'Nama maksimal 255 karakter.',

            'email.required'          => 'Email harus diisi.',
            'email.email'             => 'Format email tidak valid.',
            'email.max'               => 'Email maksimal 255 karakter.',

            'no_wa.required'          => 'Nomor WhatsApp harus diisi.',
            'no_wa.string'            => 'Nomor WhatsApp harus berupa teks.',
            'no_wa.max'               => 'Nomor WhatsApp maksimal 20 karakter.',
        ];
    }
}
