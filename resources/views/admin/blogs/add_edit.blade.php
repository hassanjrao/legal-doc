@extends('layouts.backend')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <style>
        ul,
        ol {
            margin: 0;
            padding-left: 20px;
        }

        li {
            margin: 0;
            padding: 0;
        }
    </style>
@endsection

@php
    $addEdit = isset($blog) ? 'Edit' : 'Add';
    $addUpdate = isset($blog) ? 'Update' : 'Add';
@endphp

@section('page-name', 'Add Blog')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>{{ $addEdit }} Blog</span>

                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary">All</a>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($blog)
                            <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST"
                                class="row g-3 mt-0" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('admin.blogs.store') }}" method="POST"
                                    enctype="multipart/form-data" class="row g-3 mt-0">

                                    @csrf
                        @endif

                        <div class="col-md-6">
                            <?php
                            $value = old('title', $blog ? $blog->title : null);
                            ?>

                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $value }}" required>
                            @error('title')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <?php
                            $value = old('image', $blog ? $blog->image : null);
                            ?>

                            @if ($blog)
                                <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @endif

                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" value="{{ $value }}"
                            {{ $addEdit == 'Add' ? 'required' : '' }}
                            >
                            @error('image')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <?php
                            $value = old('content', $blog ? $blog->content : null);
                            ?>

                            <label class="form-label">Content</label>
                            <textarea id="content" name="content" required class="form-control summernote">{!! $value !!}</textarea>

                            @error('content')
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,

            });
        });
    </script>
@endpush
