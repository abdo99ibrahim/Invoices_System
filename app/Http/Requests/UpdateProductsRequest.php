<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => "required|unique:products,product_name,{$this->pro_id}",
            'description'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => 'يرجى إدخال أسم المنتج ',
            'product_name.unique' => 'اسم المنتج مسجل مسبقاً',
            'description.required' => 'يرجى إدخال الوصف  ',
            'section_id.required' => 'يرجى أختيار القسم',
        ];
    }
}
