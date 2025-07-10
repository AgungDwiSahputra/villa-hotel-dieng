<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->id;
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,' . $id],
            'password' => [$id ? 'nullable' : 'required','string','min:8','confirmed'],
            'image' => [$id ? 'nullable' : 'required','image','mimes:jpeg,png,jpg','max:2048'],
        ];
    }
}
