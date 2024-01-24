@extends('theme.default')

@section('head')
<link href="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('heading')
عرض الكتب
@endsection

@section('content')
<a class="btn btn-primary" href="{{route('books.create')}}"><i class="fas fa-plus"></i> أضف كتابًا جديدًا</a>
<hr>
<div class="row">
    <div class="col-md-12">
        <table id="books-table" class="table table-stribed text-right" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>الرقم التسلسلي</th>
                    <th>التصنيف</th>
                    <th>المؤلفون</th>
                    <th>الناشر</th>
                    <th>السعر</th>
                    <th>خيارات</th>
                </tr>
            </thead>

            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td><a href="{{route('books.show',$book)}}">{{ $book->title }}</a></td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->category != null ? $book->category->name : '' }}</td>
                        <td>
                            @if($book->authers()->count() > 0)
                                @foreach($book->authers as $auther)
                                    {{ $loop->first ? '' : 'و' }}
                                    {{ $auther->name }}
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $book->publisher != null ? $book->publisher->name : '' }}</td>
                        <td>{{ $book->price }}$</td>
                        <td>
                            <a class="btn btn-link" href="{{route('books.edit',$book)}}"><i class="fa fa-edit"></i></a> 
                            <form class="d-inline-block" method="POST" action="{{route('books.destroy',$book)}}">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-link" style="background-color: white;border: none;"><i class="far fa-trash-alt text-danger fa-lg"></i></button>       
 
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<!-- Page level plugins -->
<script src="{{ asset('theme/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#books-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            }
        });
    });
</script>
@endsection