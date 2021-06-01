@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 mb-3">
                @role('patient')
                <h3>Hello, <span class="text-info">{{ Auth::user()->patient->name }}</span></h3>
                @endrole
                @role('doctor')
                <h3>Hello,  <span class="text-info">{{ Auth::user()->doctor->name }}</span></h3>
                @endrole
                @role('admin')
                <h3>Hello,  <span class="text-info">{{ Auth::user()->admin->name }}</span></h3>
                @endrole
            </div>
            @role('patient')
            <div class="col-md-12">
                <h5>Upcoming Appointment:</h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Appointment Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th width="50%">Reason</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_number }}</td>
                            <td>{{ $appointment->schedule->date }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>{{ $appointment->doctor->name }}</td>
                            <td>{{ $appointment->reason }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endrole
            @role('doctor')
            @if($appointments->count() > 0)
            <div class="col-md-12">
                <h5>Upcoming Appointment:</h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Appointment Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient</th>
                        <th width="50%">Reason</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td><a class="text-info" href="{{ route('appointments.show',$appointment->id) }}">{{ $appointment->appointment_number }}</a></td>
                            <td>{{ $appointment->schedule->date }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->reason }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
                No appointments for today
            @endif
            @endrole
            @role('admin')
            <div class="col-md-3">
                <div class="card text-white bg-danger border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Admins</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">{{ $admins->count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Doctors</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">{{ $doctors->count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Patients</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">{{ $patients->count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-custom border-0 mb-3">
                    <div class="card-header">
                        <h5>Today's Appointments</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">{{ $appointments->count() }}</h1>
                    </div>
                </div>
            </div>
            @endrole
        </div>
    </div>
@endsection
