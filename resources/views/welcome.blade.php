@extends('layouts.main')
@section('content')



<div class="container">

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Modify</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$student->first_name}}</td>
                <td>{{$student->last_name}}</td>
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
    {{$students->links()}}

</div>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

@if(session('successMsg'))

<div class="alert alert-success" role="alert">
    {{session('successMsg')}}
</div>
@endif

@endsection

@section('script')

<script>
    rm_btn = document.getElementById('remove-btn');
    console.log(rm_btn);

    rm_btn.addEventListener('onclick', function(event) {
        event.preventDefault();
        console.log('bitchhhh');

        var confirm_deletion = confirm("Are you sure you want to delete?");

        if (confirm_deletion)
            document.getElementById('delete-form-{{$student->id }}').submit();
    });
</script>

@endsection