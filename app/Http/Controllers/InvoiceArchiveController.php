<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceArchiveController extends Controller
{
    public function index(){
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.archive_invoices',compact('invoices'));
    }
    public function update(Request $request){
        $id = $request->invoice_id;
        $restore_invoice = invoices::withTrashed()->where('id',$id)->restore();
        session()->flash('restore_invoice');
        return redirect('/invoices');
    }

    public function destroy(Request $request){
        $id = $request->invoice_id;
        $attachments = invoices_attachments::where('invoice_id','=',$request->invoice_id)->first();
        $delete_invoice = invoices::withTrashed()->where('id',$id)->first();
        if(!empty($attachments->invoice_number)){
            Storage::disk('public_uploads')->deleteDirectory    ($attachments->invoice_number);
        $delete_invoice->forceDelete();
        }
        session()->flash('delete_invoice');
        return redirect('/invoices');
    }
}
