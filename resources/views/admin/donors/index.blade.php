@extends('layouts.backend')

@section('page-name', 'Donors')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>Donors</span>

                            <a href="{{ route('admin.donors.create') }}" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donors as $donor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $donor->name }}</td>
                                        <td>
                                            <img src="{{ $donor->image_url }}" alt="Donor Image"
                                                style="width: 100px; height: 100px;">
                                        </td>

                                        <td>{{ $donor->created_at}}</td>
                                        <td >

                                            <a href="{{ route('admin.donors.edit', $donor->id) }}" type="button"
                                                class="btn btn-sm btn-primary-gradient btn-wave waves-effect waves-light">Edit</a>

                                            <form action="{{ route('admin.donors.destroy', $donor->id) }}"
                                                style="display: inline-block"
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
