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
                        <table id="responsiveDataTable" class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contactUsUsers as $contactUsUser)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $contactUsUser->name }}</td>
                                        <td>{{ $contactUsUser->email }}</td>
                                        <td>{{ $contactUsUser->message }}</td>
                                        <td>{{ $contactUsUser->created_at}}</td>
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
