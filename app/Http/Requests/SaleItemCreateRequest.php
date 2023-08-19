<?php

namespace App\Http\Requests;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SaleItemCreateRequest extends FormRequest
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
            'sale_id' => ['required', Rule::exists(Sale::class, 'id')],
            'product_id' => ['required', Rule::exists(Product::class, 'id')],
            'price' => 'required',
            'quantity' => 'required',
            'payment_start_period' => 'required', 'date_format:Y-m-d',
            'payment_end_period' => 'required', 'date_format:Y-m-d',
            'cancel' => 'nullable', 'boolean'
        ];
    }

    public function message(){
        return [
            'sale_id.required' => 'Sale is required',
            'product_id.required' => 'Product name is required'
        ];
    }
}
