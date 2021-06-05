<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Doctors' Appointment System</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/start/jquery-ui.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    {{--    <link rel="stylesheet" href="css/styles.css?v=1.0">--}}
    @yield('styles')
</head>



<body url="{{ url('/') }}">
    @if(Auth::user())

    @include('layouts.navbar')
    @else
    @include('layouts.nav1')
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            Error!!
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if (session('warning'))
    <div class="alert alert-danger" role="alert">
        {{ session('warning') }}
    </div>
    @endif
    @yield('content')
    <footer class="mt-auto  bg-light" id="footer">
        <div class="container">
            <div class="d-flex justify-content-between py-3">
                <p class="copyright">Copyright &copy; DAS {{ date('Y') }}. All right reserved.</p>
                <a href="#"><img
                        src="https://facebookbrand.com/wp-content/uploads/2019/04/f_logo_RGB-Hex-Blue_512.png?w=512&h=512"
                        height="30px" alt=""></a>
            </div>
        </div>
    </footer>
    {{--<script src="js/scripts.js"></script>--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">

    </script>
    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/appointment.js') }}"></script>
    <script>

    </script>
    @yield('scripts')
</body>

</html>
