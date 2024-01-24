@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">تصنيفات الكتب</div>

                <div class="card-body">
                    <div class="row justify-content-center">

                        <form class="form-inline col-md-6" action="{{ route('gallery.category.search')}}" method="GET">
                            <input type="text" class="form-control mx-sm-3 mb-2" name="term">
                            <button type="submit" class="btn btn-secondary mb-2">ابحث</button>
                        </form>

                    </div>

                    <hr>
                    
                    <br>

                    <h5>{{ $title }}</h5>

                    @if($categores->count())
                        <ul class="list-group">
                            @foreach($categores as $category)
                                <a style="color:grey" href="{{route('gallery.category.show',$category)}}">
                                    <li class="list-group-item">
                                        {{$category->name}} {{$category->books->count()}}
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    @else 
                        <div class="alert alert-info" role="alert">
                            <h5>لا نتائج</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection