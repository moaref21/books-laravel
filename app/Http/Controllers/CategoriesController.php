<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function result(Category $category)
     {
         $books=$category->books()->paginate(12);
         $title='الكتب التابعة لتصنيف:' .$category->name;
         return view('gallery',compact(['books','title']));
     }

     public function search(Request $request)
     {
         $categores=Category::where('name','like',"%{$request->term}%")->get()->sortBy('name');
         $title='نتائج البحث:'.$request->term;
         return view('category.index',compact(['categores','title']));
     }
    public function list()
    {
        $categores=Category::all()->sortBy('name');
        $title='الاصناف';
        return view('category.index',compact(['categores','title']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories= Category::all();
        return view('admin.categories.index',compact('categories'));
    }


    public function create()
    {
        return view('admin.categories.edit');
       
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
            'desciption'=>'nullable'
        ]);
        $category=new Category();
        $category->name=$request->name;
        $category->desciption=$request->desciption;
        $category->save();
        session()->flash('flash_message',  'تمت اضافة التصنيف بنجاح');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit',compact('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,[
            'name'=>'required',
            'desciption'=>'nullable'
        ]);
        
        $category->name=$request->name;
        $category->desciption=$request->desciption;
        $category->save();
        session()->flash('flash_message',  'تمت تعديل التصنيف بنجاح');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('flash_message',  'تمت حذف التصنيف بنجاح');

        return redirect(route('categories.index'));

    }
}
