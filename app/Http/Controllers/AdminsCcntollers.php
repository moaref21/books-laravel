<?php

namespace App\Http\Controllers;

use App\Models\Auther;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;

class AdminsCcntollers extends Controller
{
   public function index()
   {
    $number_of_booke=Book::count();
    $number_of_category=Category::count();
    $number_of_auther=Auther::count();
    $number_of_publisher=Publisher::count();
    return view('admin.index',compact(['number_of_booke','number_of_category','number_of_auther','number_of_publisher']));
   }
}
