@extends('layouts.app')
@section('content')
<div class="container mt-4">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <h3 class="mb-4"><a href="{{ route('patients.index') }}" class="btn btn-dark me-2">
            <</a>Details of <span class="text-info">{{ $user->patient->name }}</span></h3>
    <div class="row">
        <div class="col-md-3">
            <img src="{{ $user->patient->photo }}" width="100%" alt="">
        </div>
        <div class="col-md-9">
            <table class="table">
                <tbody>
                    <tr>
                        <td width="150px">Name:</td>
                        <th>{{ $user->patient->name }}</th>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <th>{{ $user->patient->email }}</th>
                    </tr>
                    <tr>
                        <td>DOB:</td>
                        <th>{{ $user->patient->dob }}</th>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <th>{{ $user->patient->phone }}</th>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <th>{{ $user->patient->gender }}</th>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <th>{{ $user->patient->address }}</th>
                    </tr>
                    <tr>
                        <td>Marital Status:</td>
                        <th>{{ $user->patient->marital_status == 1 ? 'Married' : 'Unmarried' }}</th>
                    </tr>
                </tbody>
            </table>

            <a href="{{ route('patients.edit',$user->patient->id) }}" class="btn btn-custom">Edit</a>
            @if ($user->patient->user->status == true )
            <button data-bs-toggle="modal" data-bs-target="#changeStatus" class="btn btn-danger">Disable</button>
            @else
            @role('admin')
            <button data-bs-toggle="modal" data-bs-target="#changeStatus" class="btn btn-success">Enable</button>

            @endrole
            @endif

        </div>
        <div class="col-12">
            <hr>
        </div>
        <div class="col-12">
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
                <h3>Patient Reports</h3>
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addReportModal"
                    data-bs-type="create">Add New
                    report</button>
            </div>
            <div class="row">
                @foreach($user->patient->reports as $report)
                <div class="col-md-2 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <button data-bs-toggle="modal" data-bs-target="#addReportModal"
                                data-bs-image="{{$report->image}}" data-bs-id="{{$report->id}}"
                                data-bs-description="{{$report->description}}" data-bs-name="{{$report->name}}"
                                data-bs-type="edit" class="hover btn btn-danger btn-sm">Edit
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
        <div class="col-12">
            <hr>
        </div>
        <div class="col-12 mb-3">
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
                <h3>My Appointments History</h3>

            </div>
            <table id="table_id" class="display">
                <thead>

                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->patient->appointments()->where('status','!=',0)->get() as $appointment)
                    <tr>
                        <td>{{ $appointment->schedule->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>{{ $appointment->doctor->name }}</td>
                        <td class="text-center">
                            @if ($appointment->status == 1)
                            <span class="badge bg-info">Completed</span>
                            @else
                            <span class="badge bg-danger">Not Completed</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if(isset($appointment->payment))
                               A$ {{ $appointment->payment->amount }}
                                @endif
                        </td>
                        <td width="100px">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('appointments.show',$appointment->id) }}"
                                    class="btn btn-info bn-sm">Details</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
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
            <form id="updateForm" action="{{ route('patient.report.create',$user->patient->id) }}" method="POST"
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
<div class="modal fade" id="changeStatus" tabindex="-1" data-bs-backdrop="static" aria-labelledby="changeStatus"
    data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportModalLabel">Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateForm" action="{{ route('patient.changeStatus',$user->patient->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-center">

                    <h5>Do you want to {{ $user->patient->user->status == true ? 'disable' : 'enable' }} the patient
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
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
            var type = button.getAttribute('data-bs-type')
            if(type == 'edit'){
              addReportModal.querySelector('.modal-title')

            addReportModal.querySelector('#name').value = name
            addReportModal.querySelector('#description').value = description
            addReportModal.querySelector('#photo_preview').src = image
            let editUrl = '{{ route('patient.report.update',":id") }}'
            editUrl = editUrl.replace(':id', id);
            $('#updateForm').attr('action', editUrl);
            }
            else{
                addReportModal.querySelector('#name').value = ''
            addReportModal.querySelector('#description').value = ''
            addReportModal.querySelector('#photo_preview').src = ''
                let createUrl = '{{ route('patient.report.create',$user->patient->id) }}'
            $('#updateForm').attr('action', createUrl);
            }


        });

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
