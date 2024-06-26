@extends('layouts.backend')


@php
    $addEdit = isset($document) ? 'Edit' : 'Add';
    $addUpdate = isset($document) ? 'Update' : 'Add';
@endphp

@section('page-name', 'Add Document')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>{{ $addEdit }} Document</span>

                            <a href="{{ route('admin.documents.index') }}" class="btn btn-primary">All</a>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($document)
                            <form action="{{ route('admin.documents.update', $document->id) }}" method="POST"
                                class="row g-3 mt-0" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('admin.documents.store') }}" method="POST"
                                    enctype="multipart/form-data" class="row g-3 mt-0">

                                    @csrf
                        @endif
                        <div class="col-md-6">
                            <?php
                            $value = old('category', $document ? $document->documentCategory->id : null);
                            ?>
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == $value) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <?php
                            $value = old('title', $document ? $document->title : null);
                            ?>

                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $value }}">
                            @error('title')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <?php
                            $value = old('file', $document ? $document->file : null);
                            ?>

                            <label class="form-label">File</label>
                            <input type="file" class="form-control" name="file" value="{{ $value }}">
                            @error('file')
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
