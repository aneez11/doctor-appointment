@extends('layouts.app')
@section('content')
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img
                    src="https://wallpaperaccess.com/full/2153809.jpg"
                    class="d-block w-100" alt="...">

            </div>
            <div class="carousel-item">
                <img src="https://wallpaper.dog/large/10753454.jpg" class="d-block w-100" alt="...">

            </div>
            <div class="carousel-item">
                <img src="https://www.pixelstalk.net/wp-content/uploads/images1/Medical-Backgrounds-HD.jpg"
                     class="d-block w-100" alt="...">

            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="container">
        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading">We are here for you.</h2>
                <p class="lead">“In nothing do men more nearly approach the gods than in giving health to men.”― Cicero</p>
            </div>
            <div class="col-md-5 order-md-1">
                <img src="https://pngimg.com/uploads/doctor/doctor_PNG15988.png" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" alt="">


            </div>
        </div>
    </div>
    <div style="height: 100px">

    </div>
    <div style="box-shadow:0 -2px 2px 0 #00000024;">
        <div class="container py-3" style="height: 200px;">
            <div class="d-flex justify-content-between h-100">
                <img src="{{ asset('images/med-logo-01.svg') }}" class="bi me-2 my-auto" height="100%" alt="">
                <div class="text-end my-auto" style="width: 50%">
                    <h4><b>Doctor's Appointment System</b></h4>
                    <p>We are here to serve. </p>
                </div>
            </div>
        </div>
    </div>

@endsection
