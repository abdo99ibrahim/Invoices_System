<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    
    public function index()
    {
     $invoices = invoices::all();   
     $sections = sections::all();
        return view('invoices.invoices',compact('invoices','sections'));
    }

    
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    public function store(Request $request)
    {
        invoices::create([
            'invoice_number'=>$request->invoice_number,
            'invoice_date' =>$request->invoice_Date,
            'due_date' =>$request->Due_date,
            'product' =>$request->product,
            'section_id' =>$request->Section,
            'Amount_Collection' =>$request->Amount_collection,
            'Amount_Commission' =>$request->Amount_Commission,
            'discount' =>$request->Discount,
            'Rate_VAT' =>$request->Rate_VAT,
            'Value_VAT' =>$request->Value_VAT,
            'total' =>$request->Total,
            'status' =>'غير مدفوعة',
            'value_status' =>2,
            'note' =>$request->note,
        ]);
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'invoice_number' =>$request->invoice_number,
            'product' =>$request->product,
            'section' =>$request->Section,
            'status' =>'غير مدفوعة',
            'value_status' =>2,
            'note' =>$request->note,
            'invoice_id' =>$invoice_id,
            'user' =>(Auth::user()->name),
            
        ]);
        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
    }
    session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
    return back();
}

    public function show(invoices $invoices)
    {
        
    }

    public function edit($id)
    {
        // first() -> get one row  // get() -> multiple rows and loop uing foreach
        $invoices = invoices::where('id','=',$id)->first();
        $sections  =sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number'=>$request->invoice_number,
            'invoice_date' =>$request->invoice_Date,
            'due_date' =>$request->Due_date,
            'product' =>$request->product,
            'section_id' =>$request->Section,
            'Amount_Collection' =>$request->Amount_Collection,
            'Amount_Commission' =>$request->Amount_Commission,
            'discount' =>$request->Discount,
            'Rate_VAT' =>$request->Rate_VAT,
            'Value_VAT' =>$request->Value_VAT,
            'total' =>$request->Total,
            'note' =>$request->note,
        ]);
        session()->flash('Edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    public function destroy(invoices $invoices)
    {
        //
    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

}
