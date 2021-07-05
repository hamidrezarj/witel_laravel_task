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

        <form method="POST" action="{{route('store')}}">
            {{csrf_field()}}

            <div class="form-outline">
                <input type="text" id="typeText" class="form-control" name="first_name" />
                <label class="form-label" for="typeText">Firstname</label>
            </div>

            <div class="form-outline">
                <input type="text" id="typeText" class="form-control" name="last_name" />
                <label class="form-label" for="typeText">Lastname</label>
            </div>

            <div class="d-grid gap-2 col-6">
                <button class="btn btn-primary" type="submit">submit</button>
            </div>
        </form>

</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

@endsection