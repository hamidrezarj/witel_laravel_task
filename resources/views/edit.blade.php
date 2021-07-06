
@extends('layouts.main')    
@section('content')

<div class="container">
    <h3>Add Student!</h1>

        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)

            {{$error}}
            <br>

            @endforeach
        </div>
        @endif

        <form method="POST" action="{{route('update', $current_student->id)}}" enctype="multipart/form-data">
            {{csrf_field()}}
            @method('PUT')

            <div class="form-outline">
                <label class="form-label" for="typeText">Firstname</label>
                <input type="text" id="typeText" class="form-control" name="first_name" value="{{$current_student->first_name}}" />
            </div>

            <div class="form-outline">
                <label class="form-label" for="typeText">Lastname</label>
                <input type="text" id="typeText" class="form-control" name="last_name" value="{{$current_student->last_name}}" />
            </div>

            <div class="form-outline">
                <label class="form-label" for="typeText">Student ID</label>
                <input type="text" id="typeText" class="form-control" name="student_id" value="{{$current_student->student_id}}" />
            </div>

            <div class="form-outline">
                <label class="form-label" for="datepicker">Birth date</label>
                <input type="text" id="datepicker" class="form-control" name="birth_date" value="{{$current_student->birth_date}}" data-toggle="datepicker" />
            </div>

            <div class="form-outline">
                <label class="form-label" for="typeText">Sex</label>
                <select name="sex" id="sex" class="form-control">
                    <option value="">Select ...</option>

                    @foreach($sex_types as $type)
                        @if($type == $current_student->sex)
                            <option value="{{$type}}" selected>{{$type}}</option>
                        @else
                            <option value="{{$type}}">{{$type}}</option>
                        @endif
                    @endforeach

                </select>
            </div>

            <input type="file" class="form-control" id="inputGroupFile02" name="image_file" accept="image/*">

            <div class="d-grid gap-2 col-6">
                <button class="btn btn-primary" type="submit">submit</button>
            </div>
        </form>


</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

@endsection

@section('script')
<script>
    $('#datepicker').click(function() {
        console.log('fslkdsdjflk;sdjf');
    });

    $(function() {
        $('[data-toggle="datepicker"]').datepicker();
    });
</script>
@endsection