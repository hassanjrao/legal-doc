@extends('layouts.backend')

@section('page-name', 'Contact Us Users')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>Contact Us Users</span>

                        </div>
                    </div>
                    <div class="card-body">

                        {{-- filters form --}}
                        <form action="{{ route('admin.contact-us-users.index') }}" method="GET" class="w-100">
                            <div class="row d-flex justify-content-between">
                                <div class="col-md-3">
                                    <div class="form-group
                                    ">
                                        <label for="type">Type</label>
                                        <select name="type" class="form-select" onchange="this.form.submit()">
                                            <option value="all" {{ request()->type == 'all' ? 'selected' : '' }}>All</option>
                                            <option value="complaint" {{ request()->type == 'complaint' ? 'selected' : '' }}>Complaint</option>
                                            <option value="request" {{ request()->type == 'request' ? 'selected' : '' }}>Request</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>

                        <table id="responsiveDataTable" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contactUsUsers as $contactUsUser)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $contactUsUser->type }}</td>
                                        <td>{{ $contactUsUser->name }}</td>
                                        <td>{{ $contactUsUser->email }}</td>
                                        <td>{{ $contactUsUser->message }}</td>
                                        <td>{{ $contactUsUser->created_at}}</td>
                                        <td>
                                            <form id="form-{{ $contactUsUser->id }}"
                                                action="{{ route('admin.contact-us-users.destroy', $contactUsUser->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf


                                                <button type="button"
                                                    class="btn btn-sm btn-danger-gradient btn-wave waves-effect waves-light"
                                                    onclick="confirmDelete({{ $contactUsUser->id }})">Delete</button>

                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End::app-content -->
@endsection
