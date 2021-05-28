@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-content-center mb-4">
        <h2>All Available Doctors</h2>
    </div>
</div>
<div class="container mb-3">
    <div class="row">
        @foreach ($doctors as $doctor)
        <div class="col-md-3 mb-4 position-relative">
            <div class="card h-100">
                <img src="{{ $doctor->photo }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $doctor->name }}</h5>
                    <p class="card-text text-secondary">{{ $doctor->qualification }} <br>{{ $doctor->specialist }} </p>
                    <button class="btn btn-custom" data-bs-toggle="modal" data-bs-did={{ $doctor->id }}
                        data-bs-target="#appointmentModal">Book an
                        Appointment</button>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Book an Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="forEdit" action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="patient_id" value="{{ Auth::user()->patient->id }}">
                    <input type="hidden" name="doctor_id" id="docid">
                    <input type="hidden" name="date" value="" id="hiddenDate">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="date" class="col-form-label">Date:</label>
                                <select class="form-select date" name="doctor_schedule_id" id="date2">
                                    <option id="selDoc" value="" hidden selected>Select Doctor Schedule</option>

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
                                    <small>Select Date First:</small>
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
@section('styles')
<style>
    .card .card-body {
        padding-bottom: 50px;
    }

    .card-img-top {
        height: 300px;
        object-fit: container;
        padding: 15px
    }

    .card .btn-custom {
        position: absolute;
        bottom: 15px;
        left: 15px;
        right: 15px;
        width: 270px;
    }
</style>
@endsection
@section('scripts')
<script>
    //doctor appointment
      let editAppointmentModal = document.getElementById('appointmentModal')
editAppointmentModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-did')
            let route = '{{ route('api.doctor.schedule',':id') }}';
    route = route.replace(':id',id);
    console.log(route);
    $.get(route,function(schedules){
        $('#date2').html('<option id="selDoc" value="" hidden selected>Select Appointment Date</option>');
        $('.timeSlot').html('Select Date First');
        schedules.map(function(schedule){
            $('#date2')
            .append(`<option value='`+ schedule.id +
            `' start-time='`+ schedule.start_time +
            `' end-time='`+ schedule.end_time +
            `' max='`+ schedule.max_patients +
            `'>`+
            schedule.date +` (`+ schedule.day +`)(`+ schedule.start_time +`-`+ schedule.end_time +`)</option>`)
            $('#hiddenDate').val(schedule.date);
            $('#docid').val(id);
        })
    })
        //     $('#date2').append(`<option value='`+ sid +`' selected >`+ date +`</option>`);
        //     $('.timeSlot').html(`<div class="form-check">
        //    <input class="form-check-input" value="` + time +
        // `" type="radio" name="time" checked><label class="form-check-label"> ` + time +
        // ` </label></div>`);

        });

</script>
@endsection
