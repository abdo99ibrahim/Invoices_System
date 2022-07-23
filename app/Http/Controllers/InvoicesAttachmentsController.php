<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{
    
    public function index()
    {
       
    }

    
    public function create()
    {
       
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',
    
            ], [
                'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ]);
            $file_upload = $request->file('file_name');
            // بتجيب الاسم الاصلي للمرفق
            $file_name = $file_upload->getClientOriginalName();
            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_id = $request->invoice_id;
            $attachments->invoice_number = $request->invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->save();

            // Move Uploaded File
            $fileUploadedName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $fileUploadedName);
            session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
            return back();

    }

    public function show(invoices_attachments $invoices_attachments)
    {
       
    }

    public function edit(invoices_attachments $invoices_attachments)
    {
       
    }

    public function update(Request $request, invoices_attachments $invoices_attachments)
    {
       
    }

    public function destroy(invoices_attachments $invoices_attachments)
    {
       
    }
}
