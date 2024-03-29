<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function store(StoreInvoiceRequest $request)
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
            // sending mail
            $user = User::first();
            Notification::sendNow($user, new AddInvoice($invoice_id));


            session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
            return redirect('/invoices');
}

    public function show($id)
    {
        $invoices = invoices::where('id','=',$id)->first();
        $sections  =sections::all();
        return view('invoices.status_update_invoice',compact('invoices','sections'));
    }

    public function edit($id)
    {
        // first() -> get one row  // get() -> multiple rows and loop uing foreach
        $invoices = invoices::where('id','=',$id)->first();
        $sections  =sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    public function update(UpdateInvoiceRequest $request)
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
        $details = invoices_details::where('invoice_id','=',$request->invoice_id)->update([
            'invoice_number'=>$request->invoice_number,
            'product' =>$request->product,
            'section' =>$request->Section,
            'note' =>$request->note,
        ]);
        // session()->flash('Edit', 'تم تعديل الفاتورة بنجاح');
        session()->flash('edit_invoice');
        return redirect('/invoices');
    }

    public function destroy(Request $request)
    {
        $invoices = invoices::where('id','=',$request->invoice_id)->first();
        $attachments = invoices_attachments::where('invoice_id','=',$request->invoice_id)->first();

        $id_page =$request->id_page;
        if(!$id_page){
            if(!empty($attachments->invoice_number)){
                Storage::disk('public_uploads')->deleteDirectory    ($attachments->invoice_number);
         }
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');
    }
    else{
        $invoices->delete();
        session()->flash('archive_invoice');
        return redirect('/Archive');
    }
}
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
    public function status_update($id, UpdateStatusRequest $request){
        $invoices = invoices::findOrFail($id);

        if($request->status === 'مدفوعة'){
            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'invoice_id'=>$request->invoice_id,
                'invoice_number'=>$request->invoice_number,
                'product'=>$request->product,
                'section'=>$request->section,
                'status'=>$request->status,
                'Value_Status'=>1,
                'note'=>$request->note,
                'user'=>(Auth::user()->name),
                'Payment_Date'=>$request->Payment_Date,

            ]);
        }
        else{
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'invoice_id'=>$request->invoice_id,
                'invoice_number'=>$request->invoice_number,
                'product'=>$request->product,
                'section'=>$request->section,
                'status'=>$request->status,
                'Value_Status'=>3,
                'note'=>$request->note,
                'user'=>(Auth::user()->name),
                'Payment_Date'=>$request->Payment_Date,

            ]);
        }
        session()->flash('status_update');
        return redirect('/invoices');

    }

    public function paid_invoices(){
        $invoices = invoices::where('Value_Status','=',1)->get();
        return view('invoices.paid_invoices',compact('invoices'));
    }
    public function unpaid_invoices(){
        $invoices = invoices::where('Value_Status','=',2)->get();
        return view('invoices.unpaid_invoices',compact('invoices'));
    }
    public function partial_paid_invoices(){
        $invoices = invoices::where('Value_Status','=',3)->get();
        return view('invoices.partial_paid_invoices',compact('invoices'));
    }

    public function Print_invoice($id){
        $invoices = invoices::where('id','=',$id)->first();
        return view('invoices.print_invoice',compact('invoices'));
    }

    public function export(){
        return Excel::download(new InvoicesExport,'كل الفواتير.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

}
