@extends('layouts.backend')

@section('page-name', 'Fill Document')

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


                                <form action="{{ route('admin.documents.fill') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $document->id }}">
                                    <div class="form-group">
                                        <textarea id="document_content" name="document_content" class="form-control summernote">{{ $htmlContent }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>

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
        var documentPlaceholdersIds = @json($documentPlaceholdersIds);

        console.log('documentPlaceholdersIds', documentPlaceholdersIds);

        var userDocumentResponses = @json($userDocumentResponses);

        console.log('userDocumentResponses', userDocumentResponses);

        document.addEventListener('keydown', function(e) {
            console.log(e.key, e.target.tagName);
            if (e.key === ' ' && (e.target.tagName == 'INPUT' || e.target.tagName == 'TEXTAREA')) {
                // make focus on the current input
                e.target.focus();
                // add space to the input
                e.target.value += ' ';
                e.preventDefault();
            }
        });


        $(document).ready(function() {
            $('.summernote').summernote({
                height: 1300,
                toolbar: false, // Disable toolbar
                disableResizeEditor: true, // Prevent resizing
                callbacks: {
                    onInit: function() {
                        // Ensure lists are displayed correctly in the editor
                        $('.note-editable').css('list-style-type', 'disc');
                        $('.note-editable').find(':not([contenteditable])').attr('contenteditable',
                            'false');

                        // convert .editable class span to input type text
                        $('.note-editable').find('.editable').each(function() {
                            var $this = $(this);
                            var input = $('<input  type="text"  name="placeholders[]" >');
                            $this.replaceWith(input);
                        });


                        // convert the content which is in {MC_ST} AND {MC_EN} to input radio, each {MC_ST} and {MC_EN} contain heading which starts with {MCH_ST} and ends with {MCH_EN} AND the options starts with {MCO_ST} and ends with {MCO_EN}




                        // fill the placeholders with the user responses
                        $('input[name="placeholders[]"]').each(function(index) {
                            $(this).val(userDocumentResponses[index]);
                        });
                    }
                }
            });

            // form submit
            $('form').on('submit', function() {

                // disable submit button
                $('button[type="submit"]').attr('disabled', 'disabled');
                // change submit button text
                $('button[type="submit"]').text('Saving...');

                // prevent form submission
                event.preventDefault();

                // get the values of the placeholders in sequence and align them with the document placeholders
                var placeholders = [];
                $('input[name="placeholders[]"]').each(function(index) {

                    placeholders.push({
                        id: documentPlaceholdersIds[index],
                        value: $(this).val()
                    });
                });

                var radioPlaceholders = [];

                // get the values of the type=radio
                $('input[type="radio"]').each(function(index) {

                    radioPlaceholders.push({
                        name: $(this).attr('name'),
                        value: $(this).is(':checked') ? $(this).val() : ''
                    });
                });

                // remove those which have empty values
                radioPlaceholders = radioPlaceholders.filter(function(radioPlaceholder) {
                    return radioPlaceholder.value !== '';
                });



                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        id: $('input[name="id"]').val(),
                        placeholders: placeholders,
                        mcqs: radioPlaceholders
                    },
                    success: function(response) {
                        console.log('succ', response);

                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });

                        // delay before redirecting
                        setTimeout(function() {
                            // redirect to the documents page
                            window.location.href =
                                "{{ route('admin.documents.index') }}";
                        }, 1500);


                        // enable submit button
                        $('button[type="submit"]').removeAttr('disabled');
                        // change submit button text
                        $('button[type="submit"]').text('Submit');
                    },
                    error: function(error) {
                        console.log('erro', error);

                        Toast.fire({
                            icon: "error",
                            title: error.responseJSON.message
                        });

                        // enable submit button
                        $('button[type="submit"]').removeAttr('disabled');
                        // change submit button text
                        $('button[type="submit"]').text('Submit');

                    }

                });

            });

        });
    </script>
@endpush
