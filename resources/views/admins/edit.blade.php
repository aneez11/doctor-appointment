@extends('layouts.app')
@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-content-center mb-4">
            <h4>Edit Admin Details</h4>
        </div>
    </div>
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row h-100">
            <div class="col-md-7">
                <form method="POST" action="{{ route('admins.update',$admin->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="photo" class="form-label">Admin Photo</label>
                        <div>
                            <img src="{{ $admin->photo }}" id="photo_preview" class="mb-3" height="200" width="200">
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" target="photo_preview" id="photo" value="{{ old('photo') }}"
                                   name="photo">
                            @error('photo')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name',$admin->name) }}"
                               name="name" placeholder="Full Name">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email',$admin->email) }}"
                                   name="email" placeholder="name@example.com">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone',$admin->phone) }}"
                                   id="phone">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-7">
                            <label for="dob" class="form-label">DOB</label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                                   name="dob" value="{{ old('dob',$admin->dob) }}">
                            @error('dob')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="col-5">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender">
                                <option value="male" {{ $admin->gender == ' male' ? 'selected' : null }}>Male</option>
                                <option value="female" {{ $admin->gender == ' female' ? 'selected' : null }}>Female</option>
                                <option value="others" {{ $admin->gender == ' others' ? 'selected' : null }}>Others</option>
                            </select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address"
                                   class="form-control @error('address') is-invalid @enderror"  value="{{ old('address',$admin->address) }}"
                                   name="address">
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>

                    </div>
                    <div class="mb-3 card bg-success @error('password') bg-danger @enderror text-white">
                        <div class="card-header">
                            Input data if you want to change the password too
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                                       id="password">

                            </div>
                            <div class="col-6">
                                <label for="confirm" class="form-label">Confirm Password</label>
                                <input type="password" id="confirm"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"  value="{{ old('password_confirmation') }}"
                                       name="password_confirmation">


                            </div>
                            <div class="col-12">
                                @error('password')
                                <span class="" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('password_confirmation')
                                <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-custom">Submit</button>
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
    </script>
@endsection
