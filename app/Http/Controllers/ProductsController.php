<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\products;
use App\Models\sections;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    
    public function index()
    {
        $sections = sections::all();
        $products = products::all();
        return view('products.products',compact('sections','products'));
    }

    public function store(StoreProductsRequest $request)
    {
        products::create([
            'product_name'=>$request->product_name,
            'section_id'=>$request->section_id,
            'description'=>$request->description,
        ]);
        session()->flash('Add',"تم إضافة القسم بنجاح");
        return redirect('/products');
    }

    public function update(UpdateProductsRequest $request)
    {
        $id = sections::where('section_name', $request->section_name)->first()->id;
        $Products = products::findOrFail($request->pro_id);
        $Products->update([
        'product_name' => $request->product_name,
        'description' => $request->description,
        'section_id' => $id,
        ]);
 
        session()->flash('edit', 'تم تعديل المنتج بنجاح');
        return back();
    }

    public function destroy(Request $request)
    {
        products::findOrFail($request->pro_id)->delete();
        session()->flash('delete',"تم حذف القسم بنجاح");
        return back();
    }
}
