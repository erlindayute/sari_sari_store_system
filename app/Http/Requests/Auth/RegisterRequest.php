<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8', 'string'],
            'password_confirmation' => ['required', 'min:8', 'string'],
            'store_name' => ['required', 'string', 'max:255'],
            'store_city' => ['nullable', 'string', 'max:255'],
            'store_province' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:owner,manager'],
            'plan' => ['nullable', 'string', 'in:free,pro,business'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Passwords do not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'password_confirmation.required' => 'Password confirmation is required.',
            'store_name.required' => 'Store name is required.',
            'role.required' => 'Please select a role.',
            'role.in' => 'Selected role is invalid.',
        ];
    }
}
