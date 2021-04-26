<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Doctors' Appointment System</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">


    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    {{--    <link rel="stylesheet" href="css/styles.css?v=1.0">--}}

</head>
@if(Auth::user())

    @include('layouts.navbar')
@else
    @include('layouts.nav1')
@endif


<body>
@yield('content')
<footer class="mt-auto  bg-light" id="footer">
    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <p class="copyright">Copyright &copy; DAS {{ date('Y') }}. All right reserved.</p>
            <a href="#"><img src="https://facebookbrand.com/wp-content/uploads/2019/04/f_logo_RGB-Hex-Blue_512.png?w=512&h=512" height="30px" alt=""></a>
        </div>
    </div>
</footer>
{{--<script src="js/scripts.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function () {
        $('#table_id').DataTable();
    });
</script>
</body>
</html>
