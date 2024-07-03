@extends('layouts.backend')


@php
    $addEdit = isset($documentCategory) ? 'Edit' : 'Add';
    $addUpdate = isset($documentCategory) ? 'Update' : 'Add';
@endphp

@section('page-name', 'Add Document Category')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>{{ $addEdit }} Document Category</span>

                            <a href="{{ route('admin.document-categories.index') }}" class="btn btn-primary">All</a>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($documentCategory)
                            <form action="{{ route('admin.document-categories.update', $documentCategory->id) }}" method="POST"
                                class="row g-3 mt-0" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('admin.document-categories.store') }}" method="POST"
                                    enctype="multipart/form-data" class="row g-3 mt-0">

                                    @csrf
                        @endif

                        <div class="col-md-6">
                            <?php
                            $value = old('name', $documentCategory ? $documentCategory->name : null);
                            ?>

                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $value }}">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
@push('scripts')

@endpush
