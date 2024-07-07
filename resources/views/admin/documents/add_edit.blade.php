@extends('layouts.backend')



@php
    $addEdit = isset($document) ? 'Edit' : 'Add';
    $addUpdate = isset($document) ? 'Update' : 'Add';
@endphp

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

@endsection

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
                            $value = old('type', $document ? $document->documentCategory->id : null);
                            ?>
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="" disabled>Select Type</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == $value) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <?php
                            $value = old('law_area', $document ? $document->law_area_id : null);
                            ?>
                            <label class="form-label">Law Area</label>
                            <select name="law_area" class="form-select" required>
                                <option value="" disabled>Select Law Area</option>
                                @foreach ($lawAreas as $law_area)
                                    <option value="{{ $law_area->id }}" @if ($law_area->id == $value) selected @endif>
                                        {{ $law_area->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('law_area')
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
                            <input type="text" class="form-control" name="title" required value="{{ $value }}">
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

                            @if ($document)
                            <a href="{{ route('admin.documents.download',$document->id) }}" target="_blank" style="text-decoration: underline">
                                <img src="{{ asset('assets/images/media/files/documents/8.png') }}"
                                    alt="img">
                                    <span>
                                        {{ $document->title}}
                                    </span>
                            </a>
                            @endif
                            {{-- <label class="form-label">Upload Document</label>
                            <input type="file" class="form-control" name="file"
                            {{ isset($document) ? '' : 'required' }}
                            accept=".doc,.docx"
                            value="{{ $value }}">
                            @error('file')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
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
