@extends('layouts.app')
@section('content')
    <div class="container mt-4 mb-4">
        <h3 class="mb-4"><a href="{{ route('doctors.index') }}" class="btn btn-sm btn-dark me-2">
                <</a>Details of <span class="text-info">{{ $doctor->name }}</span></h3>
        <div class="row">
            <div class="col-md-3">
                <img src="{{ $doctor->photo }}" width="100%" class="img-thumbnail" alt="{{ $doctor->name }}">
            </div>
            <div class="col-md-9">
                <table class="table table-sm">
                    <tbody>
                    <tr>
                        <td width="100px">Name:</td>
                        <th>{{ $doctor->name }}</th>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <th>{{ $doctor->email }}</th>
                    </tr>
                    <tr>
                        <td>DOB:</td>
                        <th>{{ $doctor->dob }}</th>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <th>{{ $doctor->phone }}</th>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <th>{{ $doctor->gender }}</th>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <th>{{ $doctor->address }}</th>
                    </tr>
                    <tr>
                        <td>Per Session Fees:</td>
                        <th>{{ $doctor->fees }}</th>
                    </tr>
                    <tr>
                        <td>Qualification:</td>
                        <th>{{ $doctor->qualification }}</th>
                    </tr>
                    <tr>
                        <td>Specialist:</td>
                        <th>{{ $doctor->specialist }}</th>
                    </tr>

                    <tr>
                        <td>Doctor Leave Dates:</td>
                        <th>
                            @if (!empty($leaves))
                                @foreach ($leaves as $leave)
                                    <span
                                        class="badge bg-primary">{{ Carbon\Carbon::parse($leave)->format('d M Y') }}</span>

                                @endforeach
                            @else
                                <span class="badge bg-info">No leave information.</span>
                            @endif

                        </th>
                    </tr>

                    </tbody>
                </table>
                <a href="{{ route('doctors.edit',$doctor->id) }}" class="btn btn-custom">Edit</a>
                <button data-bs-toggle="modal" data-bs-target="#addLeave" class="btn btn-info">Add Leave</button>
                @if ($doctor->user->status == true )
                    <button data-bs-toggle="modal" data-bs-target="#changeStatus" class="btn btn-danger">Disable
                        Account
                    </button>
                @else
                    <button data-bs-toggle="modal" data-bs-target="#changeStatus" class="btn btn-success">Enable
                        Account
                    </button>
                @endif

            </div>
        </div>
    </div>
    <div class="container mt-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                Errors while adding Schedule
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="d-flex justify-content-between align-content-center mb-4">
            <h4 class="mb-4">Schedules of <span class="text-info">{{ $doctor->name }}</span></h4>
            <button data-bs-toggle="modal" data-bs-target="#addSchedule" type="button" data-bs-type="create"
                    class="btn btn-sm btn-custom">Add New Schedule
            </button>
        </div>
        <table id="table_id" class="table table-borderless display">
            <thead>
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th width="10%">Max Patients</th>
                <th>Status</th>
                <th width="15%">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($doctor->schedules as $schedule)
                <tr>
                    <td>{{ $schedule->date }}</td>
                    <td>{{ $schedule->day }}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td class="text-center">{{ $schedule->max_patients }}</td>
                    <td class="text-center">
                        @if($schedule->status == 1)
                            <a href="#" class="btn btn-sm btn-success">Active</a>
                        @else
                            <a href="#" class="btn btn-sm btn-secondary">Inactive</a>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button data-bs-toggle="modal" data-bs-target="#addSchedule"
                                    data-bs-id="{{ $schedule->id }}"
                                    data-bs-date="{{ $schedule->date }}" data-bs-start="{{ $schedule->start_time }}"
                                    data-bs-end="{{ $schedule->end_time }}" data-bs-max="{{ $schedule->max_patients }}"
                                    class="btn btn-warning bn-sm">Edit
                            </button>
                            <button data-bs-toggle="modal" data-bs-target="#deleteDoctor"
                                    class="btn btn-danger bn-sm">Delete
                            </button>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-content-center mb-4">
            <h4>All Appointments of <span class="text-info">{{ $doctor->name }}</span></h4>
        </div>
        <table id="table_id2" class="display">
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
            @foreach ($doctor->appointments as $appointment)
                <tr>
                    <td>{{ $appointment->schedule->date }}</td>
                    <td>{{ $appointment->time }}</td>
                    <td>{{ $appointment->doctor->name }}</td>
                    <td>{{ $appointment->patient->name }}</td>
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
                                <button data-bs-toggle="modal" data-bs-target="#appointmentModal"
                                        data-bs-id="{{ $appointment->id }}"
                                        data-bs-pid="{{ $appointment->patient->id }}"
                                        data-bs-did="{{ $appointment->doctor->id}}"
                                        data-bs-sid="{{ $appointment->schedule->id}}"
                                        data-bs-date="{{ $appointment->schedule->date}}"
                                        data-bs-time="{{ $appointment->time}}"
                                        data-bs-description="{{ $appointment->reason}}" class="btn btn-warning bn-sm">
                                    Edit
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addSchedule" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Add New Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSchedule" action="{{ route('doctors.addSchedule',$doctor->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="text" class="date form-control @error('date') is-invalid @enderror"
                                       id="date"
                                       value="{{ old('date') }}" name="date">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                       id="start_time" value="{{ old('start_time') }}" name="start_time">
                                @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                       id="end_time" value="{{ old('end_time') }}" name="end_time">
                                @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="max_patients" class="form-label">Max Patients</label>
                                <input type="number" class="form-control @error('max_patients') is-invalid @enderror"
                                       id="max_patients" value="{{ old('max_patients') }}" name="max_patients">
                                @error('max_patients')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changeStatus" tabindex="-1" data-bs-backdrop="static" aria-labelledby="changeStatus"
         data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateForm" action="{{ route('doctor.changeStatus',$doctor->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-center">

                        <h5>Do you want to {{ $doctor->user->status == true ? 'disable' : 'enable' }} the Doctor?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel"
         aria-hidden="true">
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
                        <input type="hidden" class="doctor_schedule_id" name="doctor_schedule_id" value="">
                        <input type="hidden" name="date" value="" id="hiddenDate">
                        <div class="row">
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
    <div class="modal fade" id="addLeave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Add Doctor Leave Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('doctors.addLeave',$doctor->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="date" class="form-label">Select leave Date</label>
                                <input type="text" class="date1 form-control @error('date') is-invalid @enderror"
                                       value="{{ old('date') }}" name="date">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="col-12 mt-3">
                                <div class="alert alert-danger">Warning! After this action all the appointments on the
                                    selected date will be cancelled and the process is irreversible.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="Submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.date').datepicker({
            minDate: 0,
            dateFormat: 'yy-mm-dd',
        });
        $('.date1').datepicker({
            minDate: 0,
            dateFormat: 'yy-mm-dd',
        });
        $('.date').change(function () {
            let date = $(this).val();
            console.log(date)
            let route = '{{ route('api.doctor.schedule.more',':date') }}';
            route = route.replace(':date', date);

            $.get(route, function (schedule) {
                setTime(schedule.start_time, schedule.end_time, schedule.max_patients,schedule.date)
                $('#doctor_schedule_id').val(schedule.id)
                console.log(schedule)
            })
        });
        let editModal = document.getElementById('addSchedule')

        editModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let date = button.getAttribute('data-bs-date')
            let id = button.getAttribute('data-bs-id')
            let startTime = button.getAttribute('data-bs-start')
            let endTime = button.getAttribute('data-bs-end')
            let maxPatients = button.getAttribute('data-bs-max')
            let type = button.getAttribute('data-bs-type')
            editModal.querySelector('#date').value = date
            editModal.querySelector('#start_time').value = startTime
            editModal.querySelector('#end_time').value = endTime
            editModal.querySelector('#max_patients').value = maxPatients
            let editUrl = '{{ route('doctors.editSchedule',":id") }}'
            editUrl = editUrl.replace(':id', id);
            $('#editSchedule').attr('action', editUrl);
            if (type == 'create') {
                editModal.querySelector('#date').value = ''
                editModal.querySelector('#start_time').value = ''
                editModal.querySelector('#end_time').value = ''
                editModal.querySelector('#max_patients').value = ''
                let editUrl = '{{ route('doctors.addSchedule',":id") }}'
                editUrl = editUrl.replace(':id', {{ $doctor->id }});
                $('#editSchedule').attr('action', editUrl);
            }
        });
        //doctor appointment
        let editAppointmentModal = document.getElementById('appointmentModal')
        editAppointmentModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let pid = button.getAttribute('data-bs-pid')
            let did = button.getAttribute('data-bs-did')
            let sid = button.getAttribute('data-bs-sid')
            let date = button.getAttribute('data-bs-date')
            let time = button.getAttribute('data-bs-time')
            let description = button.getAttribute('data-bs-description')
            editAppointmentModal.querySelector('.modal-title').innerHTML = 'Update Appointment Details';
            let route = '{{ route('api.doctor.schedule',':id') }}';
            route = route.replace(':id', did);
            let schs = schedules(id, route);
            setCalendar(schs);
            $('.date').val(date)
            $('.doctor_schedule_id').val(sid);
            $('.timeSlot').html(`<div class="form-check">
           <input class="form-check-input" value="` + time +
                `" type="radio" name="time" checked><label class="form-check-label"> ` + time +
                ` </label></div>`);

            let editUrl = '{{ route('appointments.update',":id") }}'
            editUrl = editUrl.replace(':id', id);
            $('#forEdit').attr('action', editUrl);
            $('#forEdit').append('<input type="hidden" name="_method" value="PUT">')
            $('#forEdit').append('<input type="hidden" name="doctor_id" value=' + did + '>')
            $('#forEdit').append('<input type="hidden" name="patient_id" value=' + pid + '>')
            $('#forEdit').append('<input type="hidden" name="description" value=' + description + '>')

        });

    </script>
@endsection
