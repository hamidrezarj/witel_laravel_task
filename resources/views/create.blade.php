@extends('layouts.main')

@section('content')

    <div class="container">

        <span class='d-flex justify-content-center mt-3'>                    
            <img src="{{asset('storage/app/public/profile_images/default.png')}}" class="image-file rounded-circle" id="profile-img" height="100" alt="" loading="lazy" />    
        </span>

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

            <div class="file mt-2">
                <input type="file" class="form-control" id="input-image" name="image_file" accept="image/*">
            </div>
            

            <div class="d-flex  justify-content-center mt-2">
                <button class="btn btn-primary" type="submit">submit</button>
            </div>
        </form>

        @if($errors->any())
            <div class="alert alert-danger mt-3" role="alert">
                @foreach($errors->all() as $error)

                {{$error}}
                <br>

                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script src="{{asset('public/js/script.js')}}"></script>
@endsection