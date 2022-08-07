<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required'
        ];
    }
    public function messages()
    {
        return[
            'name.required' => 'اسم المستخدم مطلوب ',
            'name.min' => 'يرجى ألا يقل اسم المستخدم عن ثلاثة حروف',
            'email.required' => 'البريد الإلكتروني مطلوب ',
            'email.email' => 'البريد الإلكتروني يكون على هيئة بريد إلكتروني ',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقاً',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.same' => 'كلمة المرور لست متطابقة',
            'roles_name.required' => 'تحديد الأدوار مطلوب  ',
        ];
    }
}
