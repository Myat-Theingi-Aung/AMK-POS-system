<?php

namespace App\Http\Requests;

use App\Models\CategoryType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
        $categoryId = $this->route('category')->id;
        return [
            'name' => ['required', 'max:255', Rule::unique('categories', 'name')->whereNull('deleted_at')->ignore($categoryId)],
            'category_type_id' => ['required', Rule::exists(CategoryType::class, 'id')->whereNull('deleted_at')]
        ];
    }

    public function messages()
    {
        return [
            'category_type_id.required' => "Category Type field is required"
        ];
    }
}
