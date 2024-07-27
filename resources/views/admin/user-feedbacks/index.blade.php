@extends('layouts.backend')

@section('page-name', 'User Feedbacks')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>User Feedbacks</span>

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="row">

            @foreach ($userFeedbacks as $index=> $feedback)

                <div class="col-xl-6">


                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">
                             Feedback from  {{ $feedback['user']->name }}
                            </div>
                            <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                aria-expanded="false" aria-controls="collapse{{ $index }}" class="">
                                <i class="ri-arrow-down-s-line fs-18 collapse-open"></i>
                                <i class="ri-arrow-up-s-line collapse-close fs-18"></i>
                            </a>
                        </div>
                        <div class="collapse" id="collapse{{ $index }}" style="">
                            <div class="card-body">
                                @foreach ($feedback['feedbacks'] as $feedback)
                                {{-- @dump($feedback) --}}
                                    <h6 class="card-text fw-semibold">
                                        {{ $feedback->question->question }}
                                    </h6>
                                    <p class="card-text mb-2">
                                        {{ $feedback->choice->choice }}
                                    </p>

                                    <p class="card-text mb-0">
                                      <b>Comment: </b>  {{ $feedback->comment }}
                                    </p>

                                    <hr>

                                @endforeach

                            </div>

                        </div>
                    </div>

                </div>
            @endforeach


        </div>
    </div>

    </div>
    <!-- End::app-content -->
@endsection
