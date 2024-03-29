@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">المؤلفون</div>

                <div class="card-body">
                    <div class="row justify-content-center">

                        <form class="form-inline col-md-6" action="{{ route('gallery.authers.search') }}" method="GET">
                            <input type="text" class="form-control mx-sm-3 mb-2" name="term">
                            <button type="submit" class="btn btn-secondary mb-2">ابحث</button>
                        </form>

                    </div>

                    <hr>
                    
                    <br>

                    <h3>{{ $title }}</h3>

                    @if($authers->count())
                        <ul class="list-group">
                            @foreach($authers as $auther)
                                <a style="color:grey" href="{{ route('gallery.authers.show', $auther) }}">
                                    <li class="list-group-item">
                                        {{ $auther->name }} ({{ $auther->books->count() }})
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    @else
                        <h4>لا نتائج</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection