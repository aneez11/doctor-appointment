@extends('layouts.app')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-content-center mb-4">
        <h4>All Appointments</h4>
        <a href="#" type="button" style="height: 32px" class="btn btn-sm btn-custom">Add New Appointment</a>
    </div>
    <table id="table_id" class="display">
        <thead>

            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Status</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->schedule->date }}</td>
                <td>{{ $appointment->time }}</td>
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td class="text-center">
                    @if ($appointment->status == 1)
                    <span class="badge bg-info">Completed</span>
                    @else
                    <span class="badge bg-danger">Not Completed</span>
                    @endif
                </td>
                <td width="100px">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('appointments.show',$appointment->id) }}"
                            class="btn btn-info bn-sm">Details</a>
                        <a href="" class="btn btn-warning bn-sm">Edit</a>
                        <button data-bs-toggle="modal" data-bs-target="#deleteDoctor" class="btn btn-danger bn-sm"
                            data-bs-id="" data-bs-name="">Delete</button>
                    </div>
                </td>
            </tr>

            @endforeach

        </tbody>
    </table>
</div>
@endsection
