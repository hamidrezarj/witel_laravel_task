@extends('layouts.main')
@section('content')



<div class="container">

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Profile image</th>
                <th scope="col">Firstname</th>
                <th scope="col">Lastname</th>
                <th scope="col">Student ID</th>
                <th scope="col">Birth Date</th>
                <th scope="col">Sex</th>

                <th scope="col">Modify</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>

                @if(empty($student->image_path) || is_null($student->image_path))
                    <th scope="row"><img src="{{asset('storage/app/public/profile_images/default.png')}}" class="rounded-circle" height="50" alt="" loading="lazy" /></th>

                @else
                    <th scope="row"><img src="{{asset('storage/app/public/profile_images/'.$student->image_path)}}" class="rounded-circle" height="50" alt="" loading="lazy" /></th>
                @endif

                <td>{{$student->first_name}}</td>
                <td>{{$student->last_name}}</td>
                <td>{{$student->student_id}}</td>
                <td>{{$student->birth_date}}</td>
                <td>{{$student->sex}}</td>
                <td>
                    <a href="{{route('edit', $student->id)}}"><i class="fas fa-edit"></i></a>
                    ||

                    <!-- <form method="POST" id="delete-form-{{$student->id}}" action="{{route('delete', $student->id)}}" style="display:none;">
                        {{csrf_field()}}
                        @method('DELETE');
                    </form>
                    <button type="submit" id="remove-btn"></button> -->
                    <a href="{{route('delete', $student->id)}}"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                </td>


            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginaation section -->
    <!-- {{$students->links()}} -->

    <a href="{{$students->previousPageUrl()}}"><i class="fa fa-angle-double-left"></i></a>

    @for($i=0; $i<=$students->lastPage(); $i++)

        <a href="{{$students->url($i)}}">{{$i}}</a>
        @endfor

        <a href="{{$students->nextPageUrl()}}"><i class="fa fa-angle-double-right"></i></a>

</div>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

@if(session('successMsg'))

<div class="alert alert-success" role="alert">
    {{session('successMsg')}}
</div>
@endif

@endsection

@section('script')


@endsection