@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h3 class="mb-4"><a href="{{ route('admins.index') }}" class="btn btn-dark me-2"><</a>Details of <span class="text-info">{{ $admin->name }}</span></h3>
        <div class="row">
            <div class="col-md-3">
                <img src="{{ $admin->photo }}" width="100%" alt="">
            </div>
            <div class="col-md-9">
                <table class="table">
                    <tbody>
                    <tr>
                        <td width="100px">Name: </td>
                        <th>{{ $admin->name }}</th>
                    </tr>
                    <tr>
                        <td>Email: </td>
                        <th>{{ $admin->email }}</th>
                    </tr>
                    <tr>
                        <td>DOB: </td>
                        <th>{{ $admin->dob }}</th>
                    </tr>
                    <tr>
                        <td>Phone: </td>
                        <th>{{ $admin->phone }}</th>
                    </tr>
                    <tr>
                        <td>Gender: </td>
                        <th>{{ $admin->gender }}</th>
                    </tr>
                    <tr>
                        <td>Address: </td>
                        <th>{{ $admin->address }}</th>
                    </tr>
                    </tbody>
                </table>
                <a href="{{ route('admins.edit',$admin->id) }}" class="btn btn-custom">Edit</a>
            </div>
        </div>
    </div>
@endsection
