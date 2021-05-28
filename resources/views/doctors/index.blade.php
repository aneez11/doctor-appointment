@extends('layouts.app')
@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-content-center mb-4">
        <h4>All Doctors</h4>
        <a href="{{ route('doctors.create') }}" type="button" style="height: 32px" class="btn btn-sm btn-custom">Add New
            Doctor</a>
    </div>

    <table id="table_id" class="table table-borderless display">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors as $doctor)
            <tr class="{{ $doctor->user->status == true ? null : 'inactive' }}">
                <td><img src="{{ $doctor->photo }}" height="50px" alt="{{ $doctor->name }}"></td>
                <td width="20%"><b>{{ $doctor->name }}</b></td>
                <td>{{ $doctor->email }}</td>
                <td>{{ $doctor->phone }}</td>
                <td>{{ $doctor->address }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('doctors.show',$doctor->id) }}" class="btn btn-info bn-sm">Details</a>
                        <a href="{{ route('doctors.edit',$doctor->id) }}" class="btn btn-warning bn-sm">Edit</a>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#deleteDoctor" class="btn btn-danger bn-sm"
                            data-bs-id="{{ $doctor->id }}" data-bs-name="{{ $doctor->name }}">Delete</button> --}}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="deleteDoctor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h5 class="hello"></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    let exampleModal = document.getElementById('deleteDoctor')
        exampleModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            let button = event.relatedTarget
            // Extract info from data-bs-* attributes
            let recipient = button.getAttribute('data-bs-name')
            let id = button.getAttribute('data-bs-id')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            let modalBodyInput = exampleModal.querySelector('.modal-body h5')
            let deleteUrl = '{{ route('doctors.destroy',":id") }}'
            deleteUrl = deleteUrl.replace(':id',id);
            modalBodyInput.innerHTML = 'Delete details of ' + recipient
            $('#deleteForm').attr('action',deleteUrl);
        })
</script>
@endsection
