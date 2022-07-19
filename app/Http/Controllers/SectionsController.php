<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionsRequest;
use App\Http\Requests\UpdateSectionsRequest;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{

    public function index()
    {
        $sections = sections::all();

        return view('sections.sections',compact('sections'));
    }


    public function create()
    {
        //
    }

    public function store(StoreSectionsRequest $request)
    {
        $data = $request->all();
        // التاكد من تسجيل اسم القسم مسبقا ولا يكون مكرراً
        $section_exists = sections::where('section_name','=',$data['section_name'])->exists();
        if($section_exists){
            session()->flash('Error','خطأ القسم مسجل مسبقاً');
            return redirect('/sections');
        }else{
            sections::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=>(Auth::user()->name),
            ]);
            session()->flash('Add',"تم إضافة القسم بنجاح");
            return redirect('/sections');
        }
    }

    public function update(UpdateSectionsRequest $request, sections $sections)
    {
        $id = $request->id;
        $sections = sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
        session()->flash('edit',"تم تعديل القسم بنجاح");
        return redirect('/sections');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('delete',"تم حذف القسم بنجاح");
        return redirect('/sections');
    }
}
