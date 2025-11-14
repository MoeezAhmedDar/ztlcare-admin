<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password; // CORRECT PATH

class UpdateUserRequest extends FormRequest
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
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()], // NULLABLE!
        ];
    }

    // Remove password from update if not provided
    protected function prepareForValidation()
    {
        if (empty($this->password)) {
            $this->request->remove('password');
            $this->request->remove('password_confirmation');
        }
    }
}
