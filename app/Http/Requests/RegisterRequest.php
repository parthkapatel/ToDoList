<?php

namespace App\Http\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'required|regex:/^\d{10}$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter your name',
            'phone.required' => 'Please enter your phone number',
            'phone.regex' => 'Phone number must be in 10 digits',
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'Email already exists please use another email',
            'password.required' => 'Please enter your password',
            'password.mind' => 'Password must be at least 6 characters',
            'password.required_with' => 'Please enter your confirm password',
            'password.same' => 'Passwords do not match with confirm password',
            'confirm_password.mind' => 'Confirm Password must be at least 6 characters',
        ];
    }
}
