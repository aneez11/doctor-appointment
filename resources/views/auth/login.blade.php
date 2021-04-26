@extends('layouts.app')

@section('content')
    <div class="container" style="height: 70vh">
        <div class="row h-100">
            <div class="col-md-7 my-auto">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                               name="email" placeholder="name@example.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" id="password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-custom">Submit</button>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted">Not a member yet ? <a href="{{ route('register') }}" class="color-custom">Register</a></p>
                    </div>
                </form>
            </div>
            <div class="col-md-5 my-auto">
                <img src="https://cdn.dribbble.com/users/615726/screenshots/7189691/docsoonds.png" width="100%" alt="">
            </div>
        </div>
    </div>


@endsection
