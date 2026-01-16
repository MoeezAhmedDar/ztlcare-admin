<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust if needed (e.g., only admins can create users)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'    => ['required', 'string', 'max:255'],
            'middle_name'   => ['nullable', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Password::defaults()],
            'phone'         => ['nullable', 'string', 'max:20'],
            'postcode'      => ['nullable', 'string', 'max:20'],
            'dob'           => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'role'          => ['required', 'exists:roles,name'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'dob.before_or_equal' => 'The user must be at least 18 years old.',
            'role.exists'         => 'The selected role does not exist.',
        ];
    }
}