@extends('layouts.app')
@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-content-center mb-4">
            <h4>All Appointments</h4>
            @role('admin')
            <button type="button" data-bs-toggle="modal" data-bs-target="#appointmentModal"
                    class="btn btn-sm btn-custom"
                    data-bs-type="create">Add New Appointment
            </button>
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
                <th>Type</th>
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
                    <td class="text-center"><span class="badge bg-info">{{ $appointment->type }}</span></td>
                    <td class="text-center">
                        @if ($appointment->status == 0)
                            <span class="badge bg-danger">Not Completed</span>
                        @elseif ($appointment->status == 1)
                            <span class="badge bg-success">Completed</span>
                        @elseif ($appointment->status == 2)
                            <span class="badge bg-info">Referred</span>
                        @elseif ($appointment->status == 3)
                            <span class="badge bg-secondary">Cancelled</span>
                        @endif
                    </td>
                    <td width="100px">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('appointments.show',$appointment->id) }}"
                               class="btn btn-info bn-sm">Details</a>
                            @if ($appointment->status == 0)
                                <button data-bs-toggle="modal" data-bs-target="#editAppointmentModal"
                                        data-bs-id="{{ $appointment->id }}"
                                        data-bs-pid="{{ $appointment->patient->id }}"
                                        data-bs-pname="{{ $appointment->patient->name }}"
                                        data-bs-did="{{ $appointment->doctor->id }}"
                                        data-bs-dname="{{ $appointment->doctor->name }}"
                                        data-bs-sid="{{ $appointment->schedule->id}}"
                                        data-bs-description="{{ $appointment->reason}}"
                                        data-bs-date="{{ $appointment->schedule->date}}"
                                        data-bs-time="{{ $appointment->time}}"
                                        class="btn btn-warning bn-sm">Edit
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- <input type="hidden" name="patient_id" value="{{ $patient->id }}"> --}}
                        <input type="hidden" class="doctor_schedule_id" name="doctor_schedule_id" value="">
                        <input type="hidden" name="date" value="" id="hiddenDate">
                        <div class="row">
                            <div class="col-12" @role('patient') style="display:none" @endrole>
                                <div class="mb-3">
                                    <label for="patient_id" class="col-form-label">Select Patient:</label>
                                    <select class="form-select" name="patient_id" id="patient_id" required>
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
                                    <select class="form-select" name="doctor_id" id="doctor_id" required>
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
                            <div class="col-md-12 mb-3">
                                <label for="date" class="form-label">Select Date</label>
                                <input type="text" class="date form-control @error('date') is-invalid @enderror"
                                       required
                                       value="{{ old('date') }}" name="date">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Select Appointment Type</label>
                                    <select class="form-select" id="type" aria-label="Default select example" required name="type">
                                        <option selected hidden value="">Select Appointment Type</option>
                                        <option value="In Person">In Person</option>
                                        <option value="Video">Video</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 meeting_link" style="display: none">
                                <label for="meeting_link" class="form-label">Enter Google Meet Link:</label>
                                <input type="url" class="form-control @error('meeting_link') is-invalid @enderror"

                                       value="{{ old('meeting_link') }}" name="meeting_link">
                                @error('meeting_link')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
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
    <div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="forEdit" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        {{-- <input type="hidden" name="patient_id" value="{{ $patient->id }}"> --}}
                        <input type="hidden" class="doctor_schedule_id" name="doctor_schedule_id" value="">
                        @role('doctor')
                        <input type="hidden"name="doctor_id" value="{{ Auth::user()->doctor->id }}">
                        @endrole
                        <input type="hidden" name="date" value="" id="editHiddenDate">
                        <div class="row">
                            <div class="col-12" @role('patient') style="display:none" @endrole>
                                <div class="mb-3">
                                    <label for="patient_id" class="col-form-label">Select Patient:</label>
                                    <select class="form-select" name="patient_id" id="edit_patient_id" required>
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
                            @role('admin|patient')
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="doctor_id" class="col-form-label">Select Doctor:</label>
                                    <select class="form-select" name="doctor_id" id="edit_doctor_id" required>
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
                            @endrole
                            <div class="col-md-12 mb-3">
                                <label for="date" class="form-label">Select Date</label>
                                <input type="text" class="date form-control @error('date') is-invalid @enderror"
                                       required
                                       value="{{ old('date') }}" name="date">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
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
                                              id="editDescription" name="description"></textarea>
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
        $('#doctor_id').change(function () {
            $('.date').val("");
            let id = $(this).val();
            $(".timeSlot").html("Select Appointment Date First");
            let route = '{{ route('api.doctor.schedule',':id') }}';
            route = route.replace(':id', id);
            let schs = schedules(id,route);
            setCalendar(schs);

        });
        $('.date').change(function () {
            let date = $(this).val();
            console.log(date)
            let route = '{{ route('api.doctor.schedule.more',':date') }}';
            route = route.replace(':date', date);

            $.get(route, function (schedule) {
                setTime(schedule.start_time, schedule.end_time, schedule.max_patients,schedule.date)
                console.log(schedule.id)
                $('.doctor_schedule_id').val(schedule.id)
                console.log(schedule)
            })
        });

        let editModal = document.getElementById('editAppointmentModal')
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
            let description = button.getAttribute('data-bs-description')

            editModal.querySelector('.modal-title').innerHTML = 'Update Appointment Details'
            editModal.querySelector('#editDescription').innerHTML = description
            editModal.querySelector('#editHiddenDate').value = date
            $('#edit_patient_id').append(`<option value='` + pid + `' selected >` + pname + `</option>`);
            $('#edit_doctor_id').append(`<option value='` + did + `' selected >` + dname + `</option>`);
            let route = '{{ route('api.doctor.schedule',':id') }}';
            route = route.replace(':id', did);
            let schs = schedules(did,route);
            setCalendar(schs);
            $('.date').val(date)
            $('.doctor_schedule_id').val(sid);
            $('.timeSlot').html(`<div class="form-check">
           <input class="form-check-input" value="` + time +
                `" type="radio" name="time" checked><label class="form-check-label"> ` + time +
                ` </label></div>`);
            let appUpdate = '{{ route('appointments.update',':id') }}';
            appUpdate = appUpdate.replace(':id',id)
            $('#forEdit').attr('action',appUpdate)
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

        .dp-highlight .ui-state-default {
            background: #484;
            color: #FFF;
        }
    </style>
@endsection
