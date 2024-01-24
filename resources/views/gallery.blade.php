@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
     
   <div class=" my-3">
     <div class="row justify-content-center">
                        <form class="form-inline col-md-6 justify-content-center" action="{{ route('search') }}" method="GET">
                            <input type="text" class="form-control mx-sm-3 mb-2" name="term" placeholder="ابحث عن كتاب">
                            <button type="submit" class="btn btn-secondary mb-2">ابحث</button>
                        </form>
                    </div>
                    <hr>
                    <div class="my-2">
            <h3>{{$title}}</h3>
        </div>
            <div class="row">
            @if($books->count())
                @foreach($books as $book)
               <div class="col-lg-3  col-md-4 col-sm-6 mt-2">
                
                    
                    <div class="card" style="height: 420px ;overflow:hidden">
                                        <div>
                                            <div class="card-img-actions">
                                                <a href="{{route('book.details',$book)}}">
                                                    <img src="{{asset('storage/' . $book->cover_image)}}" class="card-img img-fluid" width="96" height="350" alt="">
                                                </a>
                                               
                                            </div>
                                        </div>
    
                                        <div class="card-body bg-light text-center">
                                            <div class="mb-2">
                                                <h6 class="font-weight-semibold mb-2">
                                                    <a href="{{route('book.details',$book)}}" class="text-default card-title card-title mb-2" data-abc="true">{{$book->title}}</a>
                                                </h6>
    
                                                <a href="{{ route('gallery.category.show',$book->category)}}" class="text-muted" data-abc="true">
                                               
                                                    {{$book->category->name}}
                                                   
                                                </a>
                                            </div>
    
                                            <h3 class="mb-0 font-weight-semibold">{{$book->price}} $</h3>
    
                                            <div>
                                                <span class="stars-active" style="width: {{ $book->rate()*20 }}%">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </span>
                                            </div>
    
                                           
    
                                            <!-- <button type="button" class="btn bg-cart"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button> -->
    
                                            
                                        </div>
                                    </div>
    
    
                                
                                 
               </div> 
               @endforeach
            @else
            <div class="alert alert-info" role="alert">
                <h5>لا نتائج</h5>
            </div>
             
           
             @endif
        </div> 
    </div> 
             
    
    
    
    
    
    
    
        
</div>
    

@endsection
