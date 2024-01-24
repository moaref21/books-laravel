@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">الناشرون</div>

                <div class="card-body">
                    <div class="row justify-content-center">

                        <form class="form-inline col-md-6" action="{{route('gallery.publisher.search')}}" method="GET">
                            <input type="text" class="form-control mx-sm-3 mb-2" name="term">
                            <button type="submit" class="btn btn-secondary mb-2">ابحث</button>
                        </form>

                    </div>

                    <hr>
                    
                    <br>

                    <h3>{{ $title }}</h3>

                    @if($publishers->count())
                        <ul class="list-group">
                            @foreach($publishers as $publisher)
                                <a style="color:grey" href="{{route('gallery.publisher.show',$publisher)}}">
                                    <li class="list-group-item">
                                      {{$publisher->name}} {{$publisher->books->count()}}
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