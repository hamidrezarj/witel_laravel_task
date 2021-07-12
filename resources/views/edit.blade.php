
@extends('layouts.main')    
@section('content')

<div class="container">

    <span class='d-flex justify-content-center mt-3'>
        
        @if(empty($current_student->image_path) || is_null($current_student->image_path))
            <img src="{{asset('storage/app/public/profile_images/default.png')}}" class="image-file rounded-circle" id="profile-img" height="100" alt="" loading="lazy" />

        @else
            <img src="{{asset('storage/app/public/profile_images/'.$current_student->image_path)}}" class="image-file rounded-circle" id="profile-img" height="100" alt="" loading="lazy" />
        @endif
    </span>

    
    <form method="POST" action="{{route('update', $current_student->id)}}" enctype="multipart/form-data">
        {{csrf_field()}}
        @method('PUT')

        <!-- Add an extra input for page number passed to this blade. -->
        <input type="text" style="display: none;" name="page" value="{{$page}}">

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