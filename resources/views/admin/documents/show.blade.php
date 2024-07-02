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


@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">

                <div class="container-fluid">

                    <div class="row">
                        <div class="card custom-card">
                            <div class="card-header ">
                                <div class="card-title d-flex justify-content-between w-100">
                                    <span> Document</span>

                                    <a href="{{ route('admin.documents.index') }}" class="btn btn-primary">All</a>
                                </div>
                            </div>
                            <div class="card-body">

                                    <div class="form-group">
                                        <textarea disabled id="document_content" name="document_content" class="form-control summernote">{{ $htmlContent }}</textarea>
                                    </div>

                            </div>

                        </div>

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
                height: 1300,
                toolbar: false, // Disable toolbar
                disableResizeEditor: true, // Prevent resizing
                callbacks: {
                    onInit: function() {
                        // Ensure lists are displayed correctly in the editor
                        $('.note-editable').css('list-style-type', 'disc');
                        $('.note-editable').find(':not([contenteditable])').attr('contenteditable', 'false');


                    }
                }
            });



        });
    </script>
@endpush
