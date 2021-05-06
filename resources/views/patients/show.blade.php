@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4"><a href="{{ route('patients.index') }}" class="btn btn-dark me-2"><</a>Details of <span
                class="text-info">{{ $patient->name }}</span></h3>
        <div class="row">
            <div class="col-md-3">
                <img src="{{ $patient->photo }}" width="100%" alt="">
            </div>
            <div class="col-md-9">
                <table class="table">
                    <tbody>
                    <tr>
                        <td width="150px">Name:</td>
                        <th>{{ $patient->name }}</th>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <th>{{ $patient->email }}</th>
                    </tr>
                    <tr>
                        <td>DOB:</td>
                        <th>{{ $patient->dob }}</th>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <th>{{ $patient->phone }}</th>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <th>{{ $patient->gender }}</th>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <th>{{ $patient->address }}</th>
                    </tr>
                    <tr>
                        <td>Marital Status:</td>
                        <th>{{ $patient->marital_status == 1 ? 'Married' : 'Unmarried' }}</th>
                    </tr>
                    </tbody>
                </table>
                <a href="{{ route('patients.edit',$patient->id) }}" class="btn btn-custom">Edit</a>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12 mt-3 mb-5">
                <div class="d-flex justify-content-between mb-3">
                    <h3>Patient Reports</h3>
                    <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addReportModal">Add New report</button>
                </div>
                <div class="row">
                    @foreach($reports as $report)
                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <button data-bs-toggle="modal" data-bs-target="#addReportModal"
                                            data-bs-image="{{$report->image}}"
                                            data-bs-id="{{$report->id}}"
                                            data-bs-description="{{$report->description}}"
                                            data-bs-name="{{$report->name}}"
                                            class="hover btn btn-danger btn-sm">Edit
                                    </button>
                                    <img src="{{ $report->image }}" width="100%" alt="">
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
    <div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Add New Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Report Photo</label>
                                    <div>
                                        <img src="https://cdn.dribbble.com/users/304574/screenshots/6222816/male-user-placeholder.png" id="photo_preview" class="mb-3" height="200" width="200">
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror" target="photo_preview" id="photo" value="{{ old('photo') }}"
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
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="col-form-label">Description:</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#photo").change(function () {
                readURL(this);
            });
        });

        var addReportModal = document.getElementById('addReportModal')
        addReportModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var id = button.getAttribute('data-bs-id')
            var image = button.getAttribute('data-bs-image')
            var name = button.getAttribute('data-bs-name')
            var description = button.getAttribute('data-bs-description')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            addReportModal.querySelector('.modal-title')

            var modalTitle = addReportModal.querySelector('.modal-title')
            var modalBodyInput = addReportModal.querySelector('.modal-body input')

            // modalTitle.textContent = 'New message to ' + recipient
            // modalBodyInput.value = recipient
        })
    </script>
@endsection
@section('styles')
    <style>
        .hover {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 12px;
            z-index: 99;
        }
    </style>
@endsection
