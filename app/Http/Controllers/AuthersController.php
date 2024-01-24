<?php

namespace App\Http\Controllers;

use App\Models\Auther;
use Illuminate\Http\Request;

class authersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function result(Auther $auther)
     {
         $books=$auther->books()->paginate(12);
         $title=' الكتب التابعة للمؤلف:' .$auther->name;
         return view('gallery',compact(['books','title']));
     }

     public function search(Request $request)
     {
         $authers=Auther::where('name','like',"%{$request->term}%")->get()->sortBy('name');
         $title=' نتائج البحث عن:'.$request->term;
         return view('Auther.index',compact(['authers','title']));
     }
    public function list()
    {
     $authers=Auther::all()->sortBy('name');
        $title='المؤلفون';
        return view('Auther.index',compact(['authers','title']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authers=Auther::all()->sortBy('name');
        return view('admin.authers.index',compact('authers'));
    }


    public function create()
    {
        return view('admin.authers.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'description'=>'nullable'
        ]);
        $authers= new Auther();
        $authers->name=$request->name;
        $authers->description=$request->description;
        $authers->save();
        session()->flash('flash_message',  'تمت اضافة المؤلف بنجاح');

        return redirect(route('authers.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auther  $Auther
     * @return \Illuminate\Http\Response
     */
    public function show(Auther $Auther)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auther  $Auther
     * @return \Illuminate\Http\Response
     */
    public function edit(Auther $auther)
    {
        $authers=Auther::all();
        return view('admin.authers.edit',compact('auther'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auther  $Auther
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auther $auther)
    {
        $this->validate($request, ['name' => 'required']);
    
        $auther->name = $request->name;
        $auther->description = $request->description;
        $auther->save();
    
        session()->flash('flash_message',  'تم تعديل بيانات المؤلف بنجاح');
    
        return redirect(route('authers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\auther  $auther
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auther $auther)
    {
        $auther->delete();
        session()->flash('flash_message', 'تم حذف المؤلف بنجاح');
        return redirect(route('authers.index'));
    }

}
