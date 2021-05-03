<div class="my-nav">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container py-1">
            <a href="{{ url('/') }}" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto color-custom text-decoration-none">
                <img src="{{ asset('images/med-logo-01.svg') }}" class="bi me-2" width="40" alt="">
                <h5>Doctor's Appointment System</h5>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#footer">Contact Us</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="btn btn-custom" href="{{ route('login') }}" tabindex="-1" aria-disabled="true">Book an Appointment !</a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="btn btn-outline-custom" href="{{ route('register') }}" tabindex="-1" aria-disabled="true">Register</a>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
    </nav>
    <style>

    </style>



</div>
