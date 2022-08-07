<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRolesRequest extends FormRequest
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ];
    }
    public function messages()
    {
        return[
            'name.required'=>'اسم الصلاحية مطلوب',
            'name.unique'=>'اسم الصلاحية مسجل مسبقاً',
            'permission.required'=>'مطلوب صلاحية واحدة على الأقل',
        ];
    }
}
