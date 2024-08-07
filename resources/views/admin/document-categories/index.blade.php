@extends('layouts.backend')

@section('page-name', 'Document Types')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>Document Types</span>

                            <a href="{{ route('admin.document-categories.create') }}" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentCategories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>

                                        <td>{{ $category->created_at}}</td>
                                        <td class="d-flex">

                                            <a href="{{ route('admin.document-categories.edit', $category->id) }}" type="button"
                                                class="btn btn-sm btn-primary-gradient btn-wave waves-effect waves-light">Edit</a>

                                                <form id="form-{{ $category->id }}"
                                                    action="{{ route('admin.document-categories.destroy', $category->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf


                                                    <button type="button"
                                                        class="btn btn-sm btn-danger-gradient btn-wave waves-effect waves-light"
                                                        onclick="confirmDelete({{ $category->id }})">Delete</button>

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
