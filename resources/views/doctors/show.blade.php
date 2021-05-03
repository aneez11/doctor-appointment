@extends('layouts.app')
@section('content')
    <div class="container mt-4 mb-4">
        <h3 class="mb-4"><a href="{{ route('doctors.index') }}" class="btn btn-sm btn-dark me-2"><</a>Details of <span
                class="text-info">{{ $doctor->name }}</span></h3>
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

                    </tbody>
                </table>
                <a href="{{ route('doctors.edit',$doctor->id) }}" class="btn btn-custom">Edit</a>

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
            <button data-bs-toggle="modal" data-bs-target="#addSchedule" type="button" style="height: 32px"
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
                            <a href="" class="btn btn-info bn-sm">Details</a>
                            <button data-bs-toggle="modal" data-bs-target="#addSchedule"
                                    data-bs-id="{{ $schedule->id }}"
                                    data-bs-date="{{ $schedule->date }}"
                                    data-bs-start="{{ $schedule->start_time }}"
                                    data-bs-end="{{ $schedule->end_time }}"
                                    data-bs-max="{{ $schedule->max_patients }}"

                                    class="btn btn-warning bn-sm">Edit
                            </button>
                            <button data-bs-toggle="modal" data-bs-target="#deleteDoctor" class="btn btn-danger bn-sm"

                            >Delete
                            </button>
                        </div>
                    </td>
                    @endforeach
                </tr>
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
                                <input type="text" class="form-control @error('date') is-invalid @enderror" id="date"
                                       value="{{ old('date') }}"
                                       name="date">
                                @error('date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                                       id="start_time"
                                       value="{{ old('start_time') }}"
                                       name="start_time">
                                @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror"
                                       id="end_time"
                                       value="{{ old('end_time') }}"
                                       name="end_time">
                                @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="max_patients" class="form-label">Max Patients</label>
                                <input type="number" class="form-control @error('max_patients') is-invalid @enderror"
                                       id="max_patients"
                                       value="{{ old('max_patients') }}"
                                       name="max_patients">
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
@endsection
@section('scripts')
    <script>
        $('#date').datepicker({
            minDate: 0,
            dateFormat: 'yy-mm-dd',
        });
        let editModal = document.getElementById('addSchedule')

        editModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget
            let date = button.getAttribute('data-bs-date')
            let id = button.getAttribute('data-bs-id')
            let startTime = button.getAttribute('data-bs-start')
            let endTime = button.getAttribute('data-bs-end')
            let maxPatients = button.getAttribute('data-bs-max')
            editModal.querySelector('#date').value = date
            editModal.querySelector('#start_time').value = startTime
            editModal.querySelector('#end_time').value = endTime
            editModal.querySelector('#max_patients').value = maxPatients
            let editUrl = '{{ route('doctors.editSchedule',":id") }}'
            editUrl = editUrl.replace(':id', id);
            $('#editSchedule').attr('action', editUrl);
        })
    </script>
@endsection
