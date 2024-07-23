@extends('layouts.backend')


@php
    $addEdit = isset($feedbackQuestion) ? 'Edit' : 'Add';
    $addUpdate = isset($feedbackQuestion) ? 'Update' : 'Add';
@endphp

@section('page-name', $addEdit . ' Feedback Questions')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>{{ $addEdit }} Feedback Questions</span>

                            <a href="{{ route('admin.feedback-questions.index') }}" class="btn btn-primary">All</a>
                        </div>
                    </div>
                    <div class="card-body">

                        @if ($feedbackQuestion)
                            <form action="{{ route('admin.feedback-questions.update', $feedbackQuestion->id) }}"
                                method="POST" class="row g-3 mt-0" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('admin.feedback-questions.store') }}" method="POST"
                                    enctype="multipart/form-data" class="row g-3 mt-0">

                                    @csrf
                        @endif

                        <div class="col-md-12">
                            <?php
                            $value = old('question', $feedbackQuestion ? $feedbackQuestion->question : null);
                            ?>

                            <label class="form-label">Question</label>
                            <input type="text" required class="form-control" name="question" value="{{ $value }}">
                            @error('question')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-12" id="optionsContainer">
                            <?php
                            $choices = old('choices', $feedbackQuestion ? $feedbackQuestion->choices : []);
                            ?>

                            <div class="d-flex align-items-center mb-2">
                                <label class="form-label" style="margin-right: 10px;">Choices
                                </label>
                                <button type="button" class="btn btn-success" onclick="addOption()">
                                    {{-- icon fe --}}
                                    <i class="fe fe-plus"></i>
                                </button>
                            </div>

                            @if ($choices)
                                @foreach ($choices as $choice)
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="options[]"
                                            value="{{ $choice->choice }}" required>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeOption(this)">
                                            {{-- icon fe --}}
                                            <i class="fe fe-x"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="options[]" placeholder="Option"
                                        required>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeOption(this)">
                                        {{-- icon fe --}}
                                        <i class="fe fe-x"></i>
                                    </button>

                                </div>

                            @endif

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
    <script>
        function addOption() {
            const optionsContainer = document.getElementById('optionsContainer');
            const newOptionGroup = document.createElement('div');
            newOptionGroup.className = 'input-group mb-3';
            newOptionGroup.innerHTML = `
            <input type="text" class="form-control" name="options[]" placeholder="Option" required>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeOption(this)">
                <i class="fe fe-x"></i>
            </button>
        `;
            optionsContainer.appendChild(newOptionGroup);
        }

        function removeOption(button) {
            const optionGroup = button.parentElement;
            optionGroup.remove();
        }
    </script>
@endpush
