@extends('layouts.backend')


@php
    $addEdit = isset($testimonial) ? 'Edit' : 'Add';
    $addUpdate = isset($testimonial) ? 'Update' : 'Add';
@endphp

@section('page-name', $addEdit . ' Testimonial')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>{{ $addEdit }} Testimonial</span>

                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary">All</a>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($testimonial)
                            <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST"
                                class="row g-3 mt-0" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('admin.testimonials.store') }}" method="POST"
                                    enctype="multipart/form-data" class="row g-3 mt-0">

                                    @csrf
                        @endif

                        <div class="col-md-6">
                            <?php
                            $value = old('name', $testimonial ? $testimonial->name : null);
                            ?>

                            <label class="form-label">Name</label>
                            <input type="text" required class="form-control" name="name" value="{{ $value }}">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <?php
                            $value = old('company_name', $testimonial ? $testimonial->company_name : null);
                            ?>

                            <label class="form-label">Company Name</label>
                            <input type="text" required class="form-control" name="company_name"
                            value="{{ $value }}">
                            @error('company_name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <?php
                            $value = old('image', $testimonial ? $testimonial->image : null);
                            ?>

                            @if ($testimonial)
                                <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}"
                                    class="img-fluid" style="max-height: 100px;">
                            @endif

                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image"
                            {{ $addEdit == 'Add' ? 'required' : '' }}
                            accept="image/*"
                             value="{{ $value }}">
                            @error('image')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <?php
                            $value = old('comment', $testimonial ? $testimonial->comment : null);
                            ?>

                            <label class="form-label">Comment</label>
                           <textarea name="comment" class="form-control" required>{{ $value }}</textarea>
                            @error('comment')
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
