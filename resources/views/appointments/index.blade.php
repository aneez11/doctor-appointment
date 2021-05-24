@extends('layouts.app')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-content-center mb-4">
        <h4>All Appointments</h4>
        @role('admin')
        <button type="button" data-bs-toggle="modal" data-bs-target="#appointmentModal" class="btn btn-sm btn-custom"
            data-bs-type="create">Add New Appointment</button>
        @endrole

    </div>
    <table id="table_id" class="display">
        <thead>

            <tr>
                <th>Appointment Number</th>
                <th>Date</th>
                <th>Time</th>
                @role('admin|patient')
                <th>Doctor</th>
                @endrole
                @role('admin|doctor')
                <th>Patient</th>
                @endrole
                <th>Status</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->appointment_number }}</td>
                <td>{{ $appointment->schedule->date }}</td>
                <td>{{ $appointment->time }}</td>
                @role('admin|patient')
                <td>{{ $appointment->doctor->name }}</td>
                @endrole
                @role('admin|doctor')
                <td>{{ $appointment->patient->name }}</td>
                @endrole
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
                        <button data-bs-toggle="modal" data-bs-target="#appointmentModal"
                            data-bs-id="{{ $appointment->id }}" data-bs-pid="{{ $appointment->patient->id }}"
                            data-bs-pname="{{ $appointment->patient->name }}"
                            data-bs-did="{{ $appointment->doctor->id }}"
                            data-bs-dname="{{ $appointment->doctor->name }}"
                            data-bs-sid="{{ $appointment->schedule->id}}"
                            data-bs-description="{{ $appointment->reason}}"
                            data-bs-date="{{ $appointment->schedule->date}}" data-bs-time="{{ $appointment->time}}"
                            class="btn btn-warning bn-sm">Edit
                        </button>

                    </div>
                </td>
            </tr>

            @endforeach

        </tbody>
    </table>
</div>
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Add New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="forEdit" action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- <input type="hidden" name="patient_id" value="{{ $patient->id }}"> --}}
                    <input type="hidden" name="date" value="" id="hiddenDate">
                    <div class="row">
                        <div class="col-12" @role('patient') style="display:none" @endrole>
                            <div class="mb-3">
                                <label for="patient_id" class="col-form-label">Select Patient:</label>
                                <select class="form-select" name="patient_id" id="patient_id">
                                    <option value="" hidden selected>Select Patient</option>
                                    @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="doctor_id" class="col-form-label">Select Doctor:</label>
                                <select class="form-select" name="doctor_id" id="doctor_id">
                                    <option value="" hidden selected>Select Doctor</option>
                                    @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="date" class="col-form-label">Date:</label>
                                <select class="form-select" name="doctor_schedule_id" id="date">
                                    <option id="selDoc" value="" hidden selected>Select Doctor First</option>
                                </select>
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="time" class="col-form-label">Select Time Slot:</label>
                                <div class="timeSlot">
                                    <small>Select Doctor and Date First:</small>
                                </div>
                                @error('time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="5"
                                    id="description" name="description"></textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    //doctor appointment
  $('#doctor_id').change(function(){
    let id = $(this).val();
    let route = '{{ route('api.doctor.schedule',':id') }}';
    route = route.replace(':id',id);
    $.get(route,function(schedules){
        $('#date').html('<option id="selDoc" value="" hidden selected>Select Appointment Date</option>');
        $('.timeSlot').html('Select Date First');
        schedules.map(function(schedule){
            $('#date')
            .append(`<option value='`+ schedule.id +
            `' start-time='`+ schedule.start_time +
            `' end-time='`+ schedule.end_time +
            `' max='`+ schedule.max_patients +
            `'>`+
            schedule.date +` (`+ schedule.day +`)(`+ schedule.start_time +`-`+ schedule.end_time +`)</option>`)
            $('#hiddenDate').val(schedule.date);
        })
    })
});
let editModal = document.getElementById('appointmentModal')
editModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let pid = button.getAttribute('data-bs-pid')
            let pname = button.getAttribute('data-bs-pname')
            let did = button.getAttribute('data-bs-did')
            let dname = button.getAttribute('data-bs-dname')
            let sid = button.getAttribute('data-bs-sid')
            let date = button.getAttribute('data-bs-date')
            let time = button.getAttribute('data-bs-time')
            let type = button.getAttribute('data-bs-type')
            let description = button.getAttribute('data-bs-description')
            editModal.querySelector('.modal-title').innerHTML = 'Update Appointment Details'
            editModal.querySelector('#description').innerHTML = description
            $('#hiddenDate').val(date);
            $('#patient_id').append(`<option value='`+ pid +`' selected >`+ pname +`</option>`);
            $('#doctor_id').append(`<option value='`+ did +`' selected >`+ dname +`</option>`);
            $('#date').append(`<option value='`+ sid +`' selected >`+ date +`</option>`);
            $('.timeSlot').html(`<div class="form-check">
           <input class="form-check-input" value="` + time +
        `" type="radio" name="time" checked><label class="form-check-label"> ` + time +
        ` </label></div>`);
            let editUrl = '{{ route('appointments.update',":id") }}'
            editUrl = editUrl.replace(':id', id);
            $('#forEdit').attr('action', editUrl);
            $('#forEdit').append('<input type="hidden" name="_method" value="PUT">')
            if(type == 'create'){
                let createUrl = '{{ route('appointments.create') }}'
            $('#forEdit').attr('action', createUrl);
            }

        });
</script>
@endsection

@section('styles')
<style>
    .hover {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 12px;
        z-index: 2;
    }

    .report-image {
        width: 100%;
        height: 150px;
        object-fit: contain;
    }

    .timeSlot {
        display: grid;
        grid-gap: 10px;
        grid-template-columns: repeat(5, 1fr)
    }

    .timeSlot .form-check {
        margin-right: 10px
    }
</style>
@endsection
