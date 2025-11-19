<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'nim' => ['nullable', 'string', 'max:20', Rule::unique(User::class)->ignore($this->user()->id)],
            'jurusan' => ['nullable', 'string', 'max:255'],
            'angkatan' => ['nullable', 'integer'],
            'ipk' => ['nullable', 'numeric', 'between:0.00,4.00'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
