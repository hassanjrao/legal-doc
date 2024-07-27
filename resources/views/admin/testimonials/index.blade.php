@extends('layouts.backend')

@section('page-name', 'Testimonials')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>Testimonials</span>

                            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Image</th>
                                    <th>Comment</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($testimonials as $testimonial)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $testimonial->name }}</td>
                                        <td>{{ $testimonial->company_name }}</td>
                                        <td>
                                            <img src="{{ $testimonial->image_url }}" alt="testimonial Image"
                                                style="width: 100px; height: 100px;">
                                        </td>
                                        <td>{{ $testimonial->comment }}</td>
                                        <td>{{ $testimonial->created_at }}</td>
                                        <td class="">

                                            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                                                type="button"
                                                class="btn btn-sm btn-primary-gradient btn-wave waves-effect waves-light">Edit</a>

                                            <form id="form-{{ $testimonial->id }}"
                                                action="{{ route('admin.testimonials.destroy', $testimonial->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button"
                                                    class="btn btn-sm btn-danger-gradient btn-wave waves-effect waves-light"
                                                    onclick="confirmDelete({{ $testimonial->id }})">Delete</button>

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
