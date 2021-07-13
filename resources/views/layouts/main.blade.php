<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Material Design Bootstrap</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="{{asset('public/bootstrap-md/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <!-- <link href="{{asset('public/bootstrap-md/css/mdb.min.css')}}" rel="stylesheet"> -->
  <!-- Your custom styles (optional) -->
  <link href="{{asset('public/bootstrap-md/css/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  @yield('styles')
</head> 

<body>

  <!-- Start your project here-->
    @include('layouts.navbar')

    @yield('content')

    <div class="footer fixed-bottom">
      @include('layouts.footer')
    </div>
  <!-- Start your project here-->



  <!-- SCRIPTS -->
  
  <!-- JQuery -->
  <script type="text/javascript" src="{{asset('public/bootstrap-md/js/jquery-3.4.1.min.js')}}"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js" integrity="sha512-RCgrAvvoLpP7KVgTkTctrUdv7C6t7Un3p1iaoPr1++3pybCyCsCZZN7QEHMZTcJTmcJ7jzexTO+eFpHk4OCFAg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="{{asset('public/bootstrap-md/js/popper.min.js')}}"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="{{asset('public/bootstrap-md/js/bootstrap.min.js')}}"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="{{asset('public/bootstrap-md/js/mdb.min.js')}}"></script>

  <script src="http://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  @yield('script')
</body>

</html>
