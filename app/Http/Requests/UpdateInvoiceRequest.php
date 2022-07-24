<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'invoice_number'=>"required|unique:invoices,invoice_number,{$this->invoice_id}",
            'invoice_Date'=>'required|date|date_format:Y-m-d',
            'Due_date'=>'required|date|date_format:Y-m-d',
            'product'=>'required|max:255',
            'Section'=>'required',
            'Amount_Collection'=>'required',
            'Amount_Commission'=>'required',
            'Discount'=>'required',
            'Rate_VAT'=>'required',
            'Value_VAT'=>'required',
            'Total'=>'required',
            'note'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'invoice_number.required' => 'يرجى إدخال رقم الفاتورة ',
            'invoice_number.unique' => 'رقم الفاتورة مسجل مسبقاً',
            'invoice_number.max' => 'أقصى عدد من الحروف 255 حرف',
            'invoice_Date.required' => 'يرجى إدخال تاريخ الفاتورة ',
            'invoice_Date.date' => 'يرجى أختيار تاريخ الفاتورة ',
            'invoice_Date.date_format' => 'Y-m-d يجب انا يكون تاريخ الفاتورة',
            'Due_date.required' => 'يرجى إدخال تاريخ الأستحقاق ',
            'Due_date.date' => 'يرجى أختيار تاريخ الأستحقاق ',
            'Due_date.date_format' => 'Y-m-d يجب انا يكون تاريخ الأستحقاق',
            'product.required' => 'يرجى أختيار أسم المنتج ',
            'product.max' => 'أقصى عدد من الحروف 255 حرف',
            'Section.required' => 'يرجى أختيار القسم',
            'Amount_collection.required' => 'يرجى إدخال مبلغ التحصيل',
            'Amount_collection.numeric' => 'يجب أن يكون مبلغ التحصيل يحتوي على أرقام فقط',
            'Amount_Commission.required' => 'يرجى إدخال مبلغ العمولة',
            'Amount_Commission.numeric' => 'يجب أن يكون مبلغ العمولة يحتوي على أرقام فقط',       
            'Discount.required' => 'يرجى إدخال الخصم',
            'Discount.numeric' => 'يجب أن يكون الخصم يحتوي على أرقام فقط',
            'Rate_VAT.required' => 'يرجى أختيار نسبة ضريبة القيمة المضافة',
            'Value_VAT.required' => 'يرجى إدخال قيمة الضريبة المضافة',
            'Value_VAT.numeric' => 'يجب أن تكون  قيمة الضريبة المضافة يحتوي على أرقام فقط',
            'total.required' => 'يرجى إدخال الإجمالي شامل الضريبة ',
            'Total.numeric' => 'يجب أن يكون لإجمالي شامل الضريبة يحتوي على أرقام فقط',
            'note.required' => 'يجب إدخال ملاحظات',
    
        ];
    }
}
