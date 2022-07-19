<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateSectionsRequest extends FormRequest
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
            // 'section_name'=>'required|max:255|unique:sections,'.$this->sections->id,
            'section_name' => "required|unique:sections,section_name,{$this->id}",
            'description'=>'required',

        ];
    }
    public function messages()
{
    return [
        'section_name.required' => 'يرجى إدخال أسم القسم ',
        'section_name.unique' => 'اسم القسم مسجل مسبقاً',
        'description.required' => 'يرجى إدخال الوصف  ',
    ];
}
}
