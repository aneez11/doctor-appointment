@extends('layouts.app')
@section('content')
    <div class="container mt-4 mb-4">
        <h3 class="mb-4"><a href="{{ route('appointments.index') }}" class="btn btn-sm btn-dark me-2">
                <</a>Appointment Details of <span class="text-info">{{ $appointment->patient->name }}</span></h3>
        <div class="row">
            <div class="col-md-3">
                <img src="{{ $appointment->patient->photo }}" width="100%" class="img-thumbnail"
                     alt="{{ $appointment->patient->name }}">
            </div>
            <div class="col-md-9">
                <table class="table table-sm">
                    <tbody>
                    <tr>
                        <td width="100px">Name:</td>
                        <th>{{ $appointment->patient->name }}</th>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <th>{{ $appointment->patient->email }}</th>
                    </tr>
                    <tr>
                        <td>DOB:</td>
                        <th>{{ $appointment->patient->dob }}</th>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <th>{{ $appointment->patient->phone }}</th>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <th>{{ $appointment->patient->gender }}</th>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <th>{{ $appointment->patient->address }}</th>
                    </tr>
                    <tr>
                        <td>Appointment Date</td>
                        <th>{{ $appointment->schedule->date }}</th>
                    </tr>
                    <tr>
                        <td>Appointment Time</td>
                        <th>{{ $appointment->time }}</th>
                    </tr>
                    <tr>
                        <td>Appointment Type</td>
                        <th>
                            {{ $appointment->type }}<br>
                            @if(isset($appointment->meeting_link) & $appointment->type == 'Video')
                                Meeting Link : <br><a href="{{ $appointment->meeting_link }}"
                                                      target="_blank">{{ $appointment->meeting_link }}</a>
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <td>Reason</td>
                        <td>{{ $appointment->reason }}</td>
                    </tr>
                    </tbody>
                </table>
                @if ($appointment->status == 0)
                    @if (isset($appointment->referred_from))
                        <button class="btn btn-danger text-white mb-3" disabled>
                            Referred from {{ $appointment->referredFrom->doctor->name }}</button><br>
                    @endif
                    @role('admin|doctor')
                    <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#appointmentModal">Refer to
                        another
                        doctor
                    </button>

                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#markCompleted">Mark as
                        Completed
                    </button>
                    @endrole
                    @role('admin|patient')
                    @if ($appointment->status != 3)
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelAppointment">
                            Cancel
                            Appointment
                        </button>
                    @endif
                    @endrole
                @elseif ($appointment->status == 1)
                    <button disabled class="btn btn-success">Completed</button>
                @elseif ($appointment->status == 2)
                    <button disabled class="btn btn-info">Referred</button>
                @elseif ($appointment->status == 3)
                    <button disabled class="btn btn-secondary">Cancelled</button>
                @endif
                @if (isset($appointment->referred_to))
                    <button class="btn btn-danger text-white" disabled>
                        Referred to {{ $appointment->referredTo->doctor->name }}</button>
                @endif
            </div>
            <div class="col-12 mt-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="d-flex justify-content-between mb-3">
                    <h3>Patient Previous Reports</h3>
                    @role('doctor')
                    <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addReportModal">Add
                        New
                        report
                    </button>
                    @endrole
                </div>
                <div class="row">
                    @foreach($appointment->patient->reports as $report)
                        <div class="col-md-2 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <button data-bs-toggle="modal" data-bs-target="#addReportModal"
                                            data-bs-image="{{$report->image}}" data-bs-id="{{$report->id}}"
                                            data-bs-description="{{$report->description}}"
                                            data-bs-name="{{$report->name}}"
                                            class="hover btn btn-danger btn-sm">Edit
                                    </button>
                                    <img class="report-image" src="{{ $report->image }}" width="100%" alt="">
                                    <div class="mt-3">
                                        <p><b>{{ $report->name }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-content-center mb-4">
            <h4>Checkup Information <span class="text-info"></span></h4>
            @role('doctor')
            <button class="btn btn-custom btn-create" data-bs-toggle="modal" data-bs-target="#checkupCreate">Add New
                Information
            </button>
            @endrole
        </div>
        <table class="table">
            <thead>

            <tr>
                <th width="120px">Date</th>
                <th>Checkup Info</th>
                <th>Prescriptions</th>
                <th width="100px">actions</th>
            </tr>
            </thead>
            <tbody>
            @if (isset($appointment->referred_from))
                @foreach ($appointment->referredFrom->checkups as $checkup)
                    <tr>
                        <td>{{ $checkup->date }}</td>
                        <td>{!! substr_replace($checkup->checkup_info,"...",100) !!}</td>
                        <td>{!! substr_replace($checkup->prescriptions,"...",100) !!}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#checkupDetails"
                                        data-bs-date="{{ $checkup->date }}" data-bs-info="{{ $checkup->checkup_info }}"
                                        data-bs-prescriptions="{{ $checkup->prescriptions }}">View
                                </button>
                                @role('doctor')
                                <button class="btn btn-warning" disabled>From referral</button>
                                @endrole

                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
            @foreach ($appointment->checkups as $checkup)
                <tr>
                    <td>{{ $checkup->date }}</td>
                    <td>{!! substr_replace($checkup->checkup_info,"...",100) !!}</td>
                    <td>{!! substr_replace($checkup->prescriptions,"...",100) !!}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#checkupDetails"
                                    data-bs-date="{{ $checkup->date }}" data-bs-info="{{ $checkup->checkup_info }}"
                                    data-bs-prescriptions="{{ $checkup->prescriptions }}">View
                            </button>
                            @role('doctor')
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#checkupEdit"
                                    data-bs-date="{{ $checkup->date }}" data-bs-info="{{ $checkup->checkup_info }}"
                                    data-bs-id="{{ $checkup->id }}"
                                    data-bs-prescriptions="{{ $checkup->prescriptions }}">Edit
                            </button>
                            @endrole

                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="addReportModal" tabindex="-1" data-bs-backdrop="static"
         aria-labelledby="addReportModalLabel" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateForm" action="{{ route('patient.report.create',$appointment->patient->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Report Photo</label>
                                    <div>
                                        <img
                                            src="https://cdn.dribbble.com/users/304574/screenshots/6222816/male-user-placeholder.png"
                                            id="photo_preview" class="mb-3" height="200" width="200">
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                               target="photo_preview" id="photo" value="{{ old('photo') }}"
                                               name="photo">
                                        @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="col-form-label">Name:</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
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
    {{-- checkupCreate --}}
    <div class="modal fade" id="checkupCreate" tabindex="-1" data-bs-backdrop="static"
         aria-labelledby="addReportModalLabel"
         data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Checkup Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('checkups.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <label for="checkup_details">Checkup Details</label>
                                    <textarea name="checkup_info" id="editor1" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <label for="checkup_details">Prescription</label>
                                    <textarea name="prescriptions" id="editor2" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="checkupEdit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="checkupEditModal"
         data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Checkup Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCheckup" action="{{ route('checkups.store') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <label for="checkup_details">Checkup Details</label>
                                    <textarea name="checkup_info" id="edit_editor1" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <label for="checkup_details">Prescription</label>
                                    <textarea name="prescriptions" id="edit_editor2" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- checkup details --}}
    <div class="modal fade" id="checkupDetails" tabindex="-1" data-bs-backdrop="static"
         aria-labelledby="addReportModalLabel" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Checkup Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6><b>Date:</b> <span class="detailsDate"></span></h6>
                    <div class=" mt-3"><b>Checkup Details: </b><br><span class="detailsInfo"></span></div>
                    <div class=" mt-3"><b>Prescription: </b><br><span class="detailsPrescrip"></span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Referral --}}
    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Refer to another doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="forEdit" action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="date" value="" id="hiddenDate">
                        <input type="hidden" name="referral" value="{{ $appointment->id}}">
                        <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}"/>
                        <input type="hidden" class="doctor_schedule_id" name="doctor_schedule_id" value="">
                        <div class="row">
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
    {{-- Completed --}}
    <div class="modal fade" id="markCompleted" tabindex="-1" data-bs-backdrop="static"
         aria-labelledby="addReportModalLabel"
         data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('appointments.complete',$appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Mark this Appointment as Completed?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom">Yes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Completed --}}
    <div class="modal fade" id="cancelAppointment" tabindex="-1" data-bs-backdrop="static"
         aria-labelledby="addReportModalLabel" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('appointments.cancel',$appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Cancel This Appointment?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-custom">Yes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
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
            let schs = schedules(id, route);
            setCalendar(schs);

        });
        $('.date').change(function () {
            let date = $(this).val();
            console.log(date)
            let route = '{{ route('api.doctor.schedule.more',':date') }}';
            route = route.replace(':date', date);
            $.get(route, function (schedule) {
                setTime(schedule.start_time, schedule.end_time, schedule.max_patients)
                $('.doctor_schedule_id').val(schedule.id)
                console.log(schedule)
            })
        })
        var detailsModal = document.getElementById('checkupDetails')
        detailsModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let date = button.getAttribute('data-bs-date')
            let info = button.getAttribute('data-bs-info')
            let prescriptions = button.getAttribute('data-bs-prescriptions')
            detailsModal.querySelector('.detailsDate').innerHTML = date
            detailsModal.querySelector('.detailsInfo').innerHTML = info
            detailsModal.querySelector('.detailsPrescrip').innerHTML = prescriptions
        })
        var editModal = document.getElementById('checkupEdit')
        editModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let info = button.getAttribute('data-bs-info')
            let prescriptions = button.getAttribute('data-bs-prescriptions')
            CKEDITOR.instances['edit_editor1'].setData(info);
            CKEDITOR.instances['edit_editor2'].setData(prescriptions);
            let editUrl = '{{ route('checkups.update',":id") }}'
            editUrl = editUrl.replace(':id', id);
            $('#editCheckup').attr('action', editUrl);

        })
        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
        CKEDITOR.replace('edit_editor1');
        CKEDITOR.replace('edit_editor2');


    </script>
@endsection
