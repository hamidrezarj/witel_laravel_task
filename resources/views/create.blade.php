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

        <form method="POST" action="{{route('store')}}" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="form-outline">
                <label class="form-label" for="typeText">Firstname</label>
                <input type="text" id="typeText" class="form-control" name="first_name" />
            </div>

            <div class="form-outline">
                <label class="form-label" for="typeText">Lastname</label>
                <input type="text" id="typeText" class="form-control" name="last_name" />
            </div>

            <div class="form-outline">
                <label class="form-label" for="typeText">Student ID</label>
                <input type="text" id="typeText" class="form-control" name="student_id" />
            </div>

            <div class="form-outline">
                <label class="form-label" for="datepicker">Birth date</label>
                <input type="text" id="datepicker" class="form-control" name="birth_date" data-toggle="datepicker" />
            </div>

            <div class="form-outline">
                <label class="form-label" for="typeText">Sex</label>
                <select name="sex" id="sex" class="form-control">
                    <option value="">Select ...</option>

                    @foreach($sex_types as $type)
                    <option value="{{$type}}">{{$type}}</option>

                    @endforeach

                </select>
            </div>

            <!-- <div class="form-outline"> -->
            <!-- <label class="input-group-text" for="inputGroupFile02">Upload</label> -->

            <input type="file" class="form-control" id="inputGroupFile02" name="image_file" accept="image/*">
            <!-- </div> -->

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