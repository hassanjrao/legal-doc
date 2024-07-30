@extends('layouts.backend')

@section('page-name', 'Feedback Questions')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>Feedback Questions</span>

                            <a href="{{ route('admin.feedback-questions.create') }}" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsiveDataTable" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Choices</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedbackQuestions as $feedbackQuestion)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $feedbackQuestion->question }}</td>
                                        <td>
                                            @foreach ($feedbackQuestion->choices as $choice)
                                                <div class="alert alert-primary alert-dismissible fade show custom-alert-icon shadow-sm"
                                                    role="alert">
                                                    <span>{{ $choice->choice }}</span>
                                                </div>
                                            @endforeach
                                        </td>

                                        <td>{{ $feedbackQuestion->created_at }}</td>
                                        <td class="">

                                            <a href="{{ route('admin.feedback-questions.edit', $feedbackQuestion->id) }}"
                                                type="button"
                                                class="btn btn-sm btn-primary-gradient btn-wave waves-effect waves-light">Edit</a>

                                            <form id="form-{{ $feedbackQuestion->id }}"
                                                action="{{ route('admin.feedback-questions.destroy', $feedbackQuestion->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button"
                                                    class="btn btn-sm btn-danger-gradient btn-wave waves-effect waves-light"
                                                    onclick="confirmDelete({{ $feedbackQuestion->id }})">Delete</button>

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
