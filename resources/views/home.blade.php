@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 mb-3">
                @role('patient')
                <h3>Hello, <span class="text-info">{{ Auth::user()->patient->name }}</span></h3>
                @endrole
                @role('doctor')
                <h3>Hello,  <span class="text-info">{{ Auth::user()->doctor->name }}</span></h3>
                @endrole
                @role('admin')
                <h3>Hello,  <span class="text-info">{{ Auth::user()->admin->name }}</span></h3>
                @endrole
            </div>
            @role('patient')
            <div class="col-md-12">
                <h5>Upcoming Appointment:</h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Appointment Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>

                        <th>Type</th>
                        <th>Payment</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_number }}</td>
                            <td>{{ $appointment->schedule->date }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>{{ $appointment->doctor->name }}</td>
                            <td>
                                {{ $appointment->type }}<br>
                                @if(isset($appointment->meeting_link) & $appointment->type == 'Video')
                                    Meeting Link : <br><a href="{{ $appointment->meeting_link }}" target="_blank">{{ $appointment->meeting_link }}</a>
                                    @endif
                            </td>
                            <td class="Text-center">
                                @if(isset($appointment->payment))
                                    <button disabled="" class="btn btn-info" style="color: black !important;font-weight: 600;width: 100%">Paid
                                        <br> A$ {{ $appointment->payment->amount }}</button>

                                @else
                                    <button class="btn btn-custom"  data-bs-toggle="modal" data-bs-target="#paymentModal"
                                            data-bs-id="{{ $appointment->id }}"
                                            data-bs-amount="{{ $appointment->doctor->fees }}"
                                    >Make Payment</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endrole
            @role('doctor')
            @if($appointments->count() > 0)
            <div class="col-md-12">
                <h5>Upcoming Appointment:</h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Appointment Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Patient</th>
                        <th width="50%">Reason</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td><a class="text-info" href="{{ route('appointments.show',$appointment->id) }}">{{ $appointment->appointment_number }}</a></td>
                            <td>{{ $appointment->schedule->date }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->reason }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
                No appointments for today
            @endif
            @endrole
            @role('admin')
            <div class="col-md-3">
                <div class="card text-white bg-danger border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Admins</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">{{ $admins->count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Doctors</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">{{ $doctors->count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success border-0 mb-3">
                    <div class="card-header">
                        <h5>Total Patients</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">{{ $patients->count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-custom border-0 mb-3">
                    <div class="card-header">
                        <h5>Today's Appointments</h5>
                    </div>
                    <div class="card-body d-flex justify-content-end">
                        <h1 class="font-weight-bolder">{{ $appointments->count() }}</h1>
                    </div>
                </div>
            </div>
            @endrole
        </div>
    </div>
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Make Appointment Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <div class="row">
                       <div class="col-12 text-center">
                           <h4>Appointment Fee: <span class="text-info">A$ <span class="fee">100</span></span> </h4>
                           <hr>
                       </div>
                       <div class="col-md-12">
                           <ul class="nav nav-tabs" id="myTab" role="tablist">
                               <li class="nav-item" role="presentation">
                                   <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Credit Card</button>
                               </li>
                               <li class="nav-item" role="presentation">
                                   <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Paypal</button>
                               </li>
                               <li class="nav-item" role="presentation">
                                   <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Bank Transfer</button>
                               </li>
                           </ul>
                           <div class="tab-content" id="myTabContent">
                               <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                                                                <i class="fab fa-cc-visa"></i> &nbsp; <i class="fab fa-cc-amex"></i> &nbsp;
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
                               <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                   <p>Paypal is easiest way to pay online</p>
                                   <p>
                                       <button type="button" class="btn btn-primary"><i
                                               class="fab fa-paypal"></i> Log in my Paypal
                                       </button>
                                   </p>
                               </div>
                               <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                   <p>Bank accaunt details</p>
                                   <dl class="param">
                                       <dt>BANK:</dt>
                                       <dd> THE WORLD BANK</dd>
                                   </dl>
                                   <dl class="param">
                                       <dt>Account number:</dt>
                                       <dd> 12345678912345</dd>
                                   </dl>
                                   <dl class="param">
                                       <dt>IBAN:</dt>
                                       <dd> 123456789</dd>
                                   </dl>

                               </div>
                           </div>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('appointment.payment') }}" method="POST">
                        @csrf
                        <input type="hidden" id="appointment_id" name="appointment_id" value="">
                        <input type="hidden" id="amount" name="amount" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var paymentModal = document.getElementById('paymentModal')
        paymentModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        var id = button.getAttribute('data-bs-id')
        var amount = button.getAttribute('data-bs-amount')

        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
            paymentModal.querySelector('#appointment_id').value = id
            paymentModal.querySelector('#amount').value = amount
            paymentModal.querySelector('.fee').textContent = amount
            paymentModal.querySelector('.modal-body input')

        })
    </script>
@endsection
