@extends('layouts.backend')

@section('page-name', 'Users')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>Users</span>

                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{
                                            $user->roles->pluck('name')->implode(', ')
                                            
                                         }}</td>

                                        <td>{{ $user->created_at}}</td>
                                        <td>

                                            <a href="{{ route('admin.users.edit', $user->id) }}" type="button"
                                                class="btn btn-sm btn-primary-gradient btn-wave waves-effect waves-light">Edit</a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                method="POST" style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger-gradient btn-wave waves-effect waves-light"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
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
