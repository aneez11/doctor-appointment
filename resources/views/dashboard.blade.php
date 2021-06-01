@extends('layouts.app')
@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-danger border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Users</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">50</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Doctors</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">50</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Patients</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">50</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-custom border-0 mb-3">
                    <div class="card-header">
                        <h5>Today's Appointments</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">50</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
