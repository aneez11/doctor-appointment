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
                            <p class="card-text text-secondary">{{ $doctor->qualification }}
                                <br>{{ $doctor->specialist }} </p>
                            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-did="{{ $doctor->id }}"
                                    data-bs-fee="{{ $doctor->fees }}"
                                    data-bs-target="#appointmentModal">Book an
                                Appointment
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <div class="modal fade" id="appointmentModal" data-bs-backdrop="static" tabindex="-1"
         aria-labelledby="appointmentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Book an Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="forEdit" action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <input name="doctor_schedule_id" id="doctor_schedule_id" value="" hidden>
                    <div class="modal-body">
                        <input type="hidden" name="patient_id" value="{{ Auth::user()->patient->id }}">
                        <input type="hidden" name="doctor_id" id="docid" value="">
                        <input type="hidden" name="date" value="" id="hiddenDate">
                        <input type="hidden" name="payment" value="true">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <h5>Appointment Information</h5>
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
                                                <small>Select Date First:</small>
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
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      rows="5"
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
                            <div class="col-md-6">
                                <div class="col-12 mb-2">
                                    <h5>Payment Information</h5>

                                </div>
                                <div class="col-12 text-center">
                                    <h4>Appointment Fee: <span class="text-info">A$ <span class="fee">100</span></span>
                                    </h4>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                                    aria-selected="true">Credit Card
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                    data-bs-target="#profile" type="button" role="tab"
                                                    aria-controls="profile" aria-selected="false">Paypal
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                    data-bs-target="#contact" type="button" role="tab"
                                                    aria-controls="contact" aria-selected="false">Bank Transfer
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                                             aria-labelledby="home-tab">
                                            {{--                                            <p class="alert alert-success">Some text success or error</p>--}}
                                            <div class="form-group mt-2">
                                                <label for="username">Full name (on the card)</label>
                                                <input type="text" class="form-control" name="username"
                                                       placeholder="" required="">
                                            </div> <!-- form-group.// -->

                                            <div class="form-group mt-2">
                                                <label for="cardNumber">Card number</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                           name="cardNumber" placeholder="">
                                                    <div class="input-group-append">
                                                            <span class="input-group-text text-muted">
                                                                <i class="fab fa-cc-visa"></i> &nbsp; <i
                                                                    class="fab fa-cc-amex"></i> &nbsp;
                                                                <i class="fab fa-cc-mastercard"></i>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div> <!-- form-group.// -->

                                            <div class="row mt-2">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        <label><span class="hidden-xs">Expiration</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                   placeholder="MM" name="">
                                                            <input type="number" class="form-control"
                                                                   placeholder="YY" name="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label data-toggle="tooltip" title=""
                                                               data-original-title="3 digits code on back side of the card">CVV
                                                            <i class="fa fa-question-circle"></i></label>
                                                        <input type="number" class="form-control"
                                                        >
                                                    </div> <!-- form-group.// -->
                                                </div>
                                            </div> <!-- row.// -->
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel"
                                             aria-labelledby="profile-tab">
                                            <p>Paypal is easiest way to pay online</p>
                                            <p>
                                                <button type="button" class="btn btn-primary"><i
                                                        class="fab fa-paypal"></i> Log in my Paypal
                                                </button>
                                            </p>
                                        </div>
                                        <div class="tab-pane fade" id="contact" role="tabpanel"
                                             aria-labelledby="contact-tab">
                                            <p>Bank accaunt details</p>
                                            <dl class="param">
                                                <dt>BANK:</dt>
                                                <dd> THE WORLD BANK</dd>
                                            </dl>
                                            <dl class="param">
                                                <dt>Accaunt number:</dt>
                                                <dd> 12345678912345</dd>
                                            </dl>
                                            <dl class="param">
                                                <dt>IBAN:</dt>
                                                <dd> 123456789</dd>
                                            </dl>
                                            <p><strong>Note:</strong> Lorem ipsum dolor sit amet,
                                                consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. </p>
                                        </div>
                                    </div>
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

        .card-text {
            min-height: 120px;
            margin: 0;
        }

        .card-img-top {
            height: 300px;
            object-fit: contain;
            padding: 15px
        }

        .card .btn-custom {
            /*position: absolute;*/
            width: 100%;
            /*width: 270px;*/
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
            let fee = button.getAttribute('data-bs-fee')
            let route = '{{ route('api.doctor.schedule',':id') }}';
            editAppointmentModal.querySelector('.fee').textContent = fee
            route = route.replace(':id', id);
            console.log(route);
            $('#docid').val(id)
            let schs = schedules(id, route);
            setCalendar(schs);
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

    </script>
@endsection
