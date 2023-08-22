<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^(09-|01-|\+?959-)\d{9}$/'],
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email|max:255',
            'NRC' => 'nullable',
            'insurance_name' => 'nullable',
            'color' => 'required',
            'food' => 'required',
            'role' => 'nullable|in:admin,user'
        ];
    }
}
