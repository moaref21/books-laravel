<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Auther;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BooksController extends Controller
{

    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct() 
     {
         $this->middleware('auth');
     }
    public function details(Book $book)
    {
        return view('book.details',compact('book'));
    }



    public function index()
    {
        $books=Book::all();
        return view('admin.book.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $publishers=Publisher::all();
        $authers=Auther::all();

        return view('admin.book.create',compact('categories','publishers','authers'));
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
        'isbn' => ['required', 'alpha_num', Rule::unique('books', 'isbn')],
        'cover_image' => 'image|required', 
        'category' => 'nullable',
        'authers' => 'nullable',
        'publisher' => 'nullable',
        'description' => 'nullable',
        'publish_year' => 'numeric|nullable',
        'number_of_pages' => 'numeric|required',
        'number_of_copies' => 'numeric|required',
        'price' => 'numeric|required',
       ]);

       $book=new Book();
       $book->title=$request->title;
       $book->isbn=$request->isbn;
    //    $cover_image=Image::make($request->cover_image)->resize(320,200);
       $book->cover_image=$cover_image=request('cover_image')->store('images/covers','public');
    //    $book->cover_image = $this->uploadImage( $request->cover_image );
    
    //    $book->cover_image=$cover_image($request->cover_image) ;
       $book->category_id=$request->category;
       $book->publisher_id=$request->publisher;
       $book->description = $request->description;
       $book->publisher_year = $request->publish_year;
       $book->number_of_pages = $request->number_of_pages;
       $book->number_of_copies = $request->number_of_copies;
       $book->price = $request->price;

       $book->save();
       $book->authers()->attach($request->authers);
       return redirect(route('books.index', $book));
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('admin.book.show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categories=Category::all();
        $publishers=Publisher::all();
        $authers=Auther::all();

        return view('admin.book.edit',compact('book','categories','publishers','authers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $this->validate($request,[
           
            'cover_image' => 'image', 
            'category' => 'nullable',
            'authers' => 'nullable',
            'publisher' => 'nullable',
            'description' => 'nullable',
            'publish_year' => 'numeric|nullable',
            'number_of_pages' => 'numeric|required',
            'number_of_copies' => 'numeric|required',
            'price' => 'numeric|required',
           ]);
    
           $book=new Book();
           $book->title=$request->title;
           $book->isbn=$request->isbn;
           $book->title = $request->title;
           if ($request->has ('cover_image')) {
               Storage::disk('public')->delete($book->cover_image);
               $book->cover_image=$cover_image=request('cover_image')->store('images/covers','public');
              
           }
    
       
           $book->category_id=$request->category;
           $book->publisher_id=$request->publisher;
           $book->description = $request->description;
           $book->publisher_year = $request->publish_year;
           $book->number_of_pages = $request->number_of_pages;
           $book->number_of_copies = $request->number_of_copies;
           $book->price = $request->price;
    
           if($book->isDirty('isbn')){
            $this->validate($request,[
            'isbn' => ['required', 'alpha_num', Rule::unique('books', 'isbn')],
            ]);
           }
           $book->save();
           $book->authers()->detach();
           $book->authers()->attach($request->authers);
           return redirect(route('books.index', $book));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect(route('books.index', $book));
    }

    public function rate(Request $request, Book $book ,User $user )
    {
       
        if(auth()->user()->rated($book)) {
            $rating = Rating::where(['user_id' => auth()->user()->id, 'book_id' => $book->id])->first();
            $rating->value = $request->value;
            $rating->save();
        } else {
            $rating = new Rating;
            $rating->user_id = auth()->user()->id;
            $rating->book_id = $book->id;
            $rating->value = $request->value;
            $rating->save();
        }

        return back();
    }



   

}
