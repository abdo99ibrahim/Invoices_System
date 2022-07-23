<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoicesDetailsController extends Controller
{
    
    public function index()
    {
        
    }

    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show(invoices_details $invoices_details)
    {
        
    }

    public function edit($id)
    {
        $invoices = invoices::where('id','=',$id)->first();
        $details = invoices_details::where('invoice_id',$id)->get();
        $attachments = invoices_attachments::where('invoice_id',$id)->get();
        return view('invoices.details_invoice',compact('invoices','details','attachments'));

    }
    public function update(Request $request, invoices_details $invoices_details)
    {
        
    }

    public function destroy(Request $request)
    {
        $invoices = invoices_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete',"تم حذف الفاتورة بنجاح");
        return back();
    }
    // public function open_file($invoice_number,$file_name)

    // {
    //     $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
    //     return response()->file($files);
    // }

    // public function get_file($invoice_number,$file_name)

    // {
    //     $contents = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
    //     $headers = array(
    //         'Content-Type: ' . mime_content_type( $contents ),
    //     );
    //     return response()->download($contents,$headers);
    // }
}