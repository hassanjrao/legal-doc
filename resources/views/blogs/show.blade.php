@extends('layouts.front')

@section('page-title', 'Blog: '.$blog->title)

@section('content')

    <div class="container mt-5">

        <section class="section " id="about">
            <div class="container text-center">
                <h1 class=" mb-1"><span class="">
                        {{ $blog->title }}
                    </span>
                </h1>
                <span class="landing-title"></span>

            </div>
            <div class="row mt-2">

                <div class="col-lg-12">
                    {!! $blog->content !!}
                </div>
            </div>

        </section>

    </div>

@endsection
