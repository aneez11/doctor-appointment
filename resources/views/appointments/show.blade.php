@extends('layouts.app')
@section('content')
<div class="container mt-4 mb-4">
    <h3 class="mb-4"><a href="{{ route('doctors.index') }}" class="btn btn-sm btn-dark me-2">
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
                </tbody>
            </table>
        </div>

    </div>
</div>
<div class="modal fade" id="addReportModal" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="addReportModalLabel" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportModalLabel">Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateForm" action="{{ route('patient.report.create',$appointment->patient->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="photo" class="form-label">Report Photo</label>
                                <div>
                                    <img src="https://cdn.dribbble.com/users/304574/screenshots/6222816/male-user-placeholder.png"
                                        id="photo_preview" class="mb-3" height="200" width="200">
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                        target="photo_preview" id="photo" value="{{ old('photo') }}" name="photo">
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
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
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
@endsection
