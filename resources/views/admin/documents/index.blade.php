@extends('layouts.backend')

@section('page-name', 'Documents')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>Documents</span>

                            <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Law Area</th>
                                    <th>Title</th>
                                    <th>Document</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $document)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $document->documentCategory->name }}</td>
                                        <td>{{ $document->lawArea ? $document->lawArea->name : '' }}</td>
                                        <td>{{ $document->title }}</td>
                                        <td>
                                            <a href="{{ $document->file_url }}" target="_blank">
                                                <img src="{{ asset('assets/images/media/files/documents/8.png') }}"
                                                    alt="img">
                                            </a>
                                        </td>
                                        <td>{{ $document->created_at }}</td>
                                        <td class="">




                                            @hasrole('admin')
                                                <a href="{{ route('admin.documents.edit', $document->id) }}" type="button"
                                                    class="btn btn-sm btn-primary-gradient btn-wave waves-effect waves-light">Edit</a>
                                                <a href="{{ route('admin.documents.show', $document->id) }}" type="button"
                                                    class="btn btn-sm btn-primary-gradient btn-wave waves-effect waves-light">View</a>
                                                <a href="{{ route('admin.documents.download', $document->id) }}" type="button"
                                                    class="btn btn-sm btn-warning-gradient btn-wave waves-effect waves-light">Download</a>
                                                <form id="form-{{ $document->id }}"
                                                    action="{{ route('admin.documents.destroy', $document->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf


                                                    <button type="button"
                                                        class="btn btn-sm btn-danger-gradient btn-wave waves-effect waves-light"
                                                        onclick="confirmDelete({{ $document->id }})">Delete</button>

                                                </form>
                                            @endhasrole


                                            @hasanyrole('user|company')
                                                <a href="{{ route('admin.documents.showFillForm', $document->id) }}"
                                                    type="button"
                                                    class="btn btn-sm btn-primary-gradient btn-wave waves-effect waves-light">Edit</a>
                                                <a href="{{ route('admin.documents.download.user', $document->id) }}"
                                                    type="button"
                                                    class="btn btn-sm btn-warning-gradient btn-wave waves-effect waves-light">Download</a>
                                            @endhasanyrole


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
