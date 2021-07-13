@extends('layouts.main')

@section('styles')
<link rel="stylesheet" href="{{url('public/css/styles.css')}}">
@endsection

@section('content')

<div class="container">

    @if(session('bad_param_error'))
    <div class="alert alert-danger" role="alert">
        {{session('bad_param_error')}}
    </div>
    @endif


    <form method="GET" action="{{route('home')}}">
        <!-- {{csrf_field()}} -->
        <div class="d-flex flex-row">
            <div class="input-group mb-3 ml-auto mt-2 col-4" id="search_field">

                <input type="text" class="form-control" name="search_firstname" id="search_firstname" value="{{$searched_firstname}}" placeholder="Search here.." aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
            
            <div class="form-inline">
                <label class="form-label" for="typeText">Sex</label>
                <select name="search_sex" id="search_sex" class="form-control">
                    <option value="">Select ...</option>

                    @foreach($sex_types as $type)
                        @if($type == $searched_sex)
                            <option value="{{$type}}" selected>{{$type}}</option>
                        @else
                            <option value="{{$type}}">{{$type}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </form>


    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Profile image</th>
                <th scope="col">Firstname</th>
                <th scope="col">

                    @if(empty($lastname_order))
                        <a href="{{$lastname_href}}" class="sort_elements" id="sort_lastname"><i class="fas fa-sort"></i></a> Lastname
                    @elseif($lastname_order == 'asc')
                        <a href="{{$lastname_href}}" class="sort_elements" id="sort_lastname"><i class="fas fa-sort-down"></i></a> Lastname
                    @else
                        <a href="{{$lastname_href}}" class="sort_elements" id="sort_lastname"><i class="fas fa-sort-up"></i></a> Lastname
                    @endif

                </th>
                <th scope="col">Student ID</th>
                <th scope="col">

                    @if(empty($birthdate_order))
                        <a href="{{$birthdate_href}}" class="sort_elements" id="sort_birthdate"><i class="fas fa-sort"></i></a> Birth date
                    @elseif($birthdate_order == 'asc')
                        <a href="{{$birthdate_href}}" class="sort_elements" id="sort_birthdate"><i class="fas fa-sort-down"></i></a> Birth date
                    @else
                        <a href="{{$birthdate_href}}" class="sort_elements" id="sort_birthdate"><i class="fas fa-sort-up"></i></a> Birth date
                    @endif

                </th>
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
                    <!-- <h3>{{$students->count()}}</h3> -->
                    @if($students->currentPage() > 1)
                        <a href="{{route('edit', ['id' => $student->id, 'page' => $students->currentPage()])}}" id="edit_link"><i class="fas fa-edit"></i></a>
                    @else
                        <a href="{{route('edit', ['id' => $student->id])}}" id="edit_link"><i class="fas fa-edit"></i></a>
                    @endif
                    ||
                    
                    @if($students->currentPage() > 1)
                        <a href="{{route('delete', ['id' => $student->id, 'page' => $students->currentPage(), 'count' => $students->count()])}}"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                    @else
                        <a href="{{route('delete', ['id' => $student->id])}}"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                    @endif
                </td>


            </tr>
            @endforeach
        </tbody>
    </table>



    <!-- Pagination section -->
    <div class="d-flex justify-content-center">
        {{$students->links('vendor.pagination.custom')}}
    </div>

    @if(session('successMsg'))
        <div class="alert alert-success" role="alert">
            {{session('successMsg')}}
        </div>
    @endif
</div>



@endsection

@section('script')
    <script>

        // Autocomplete logic using AJAX
        $('#search_firstname').autocomplete({
            source: function(request, response){

                $.ajax({
                    type: "GET",
                    url: "{{route('search_ajax')}}",
                    dataType: 'json',
                    data: {
                        //query parameter => ?search_firstname = sth
                        search_firstname:  request.term,
                    },
                    
                    success: function(data){
                        console.log(data);
                        
                        response($.map(data, function(item){
                            return item.first_name;
                        }));
                    },
                    error: function(data){
                        console.log('errors: ', data);
                    }
                });
            },

            minLength: 1,

        });

        document.getElementById('search_sex').addEventListener('change', (event) =>{

            let val = event.target.value;
            if(val){
                let base_url = '{{url()->current()}}';
                base_url += '?search_sex=' + val;
                window.location.href = base_url; 
            }
        });
    </script>
@endsection