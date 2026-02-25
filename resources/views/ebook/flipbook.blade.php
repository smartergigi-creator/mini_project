@extends('layout.app')

@section('title', 'Flipbook')
@section('body-class', 'ebook-view')

@section('content')
    <div class="container-fluid vh-100 d-flex flex-column">

        <div class="row">
            <div class="col-12 text-start py-2">
                <a href="{{ url('/home#ebooksSection') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i>Back
                </a>


                <h2 class="title mb-0">{{ $ebook->title }}</h2>
            </div>
        </div>

        <div class="row flex-grow-1">
            <div class="col-12 d-flex justify-content-center align-items-start">
                <div id="viewer-wrapper" class="mb-3">

                    <div class="viewer-toolbar position-absolute top-0 end-0 m-3 d-flex gap-2">

                        <button id="zoomIn" class="btn btn-light btn-sm">
                            <i class="bi bi-zoom-in"></i>
                        </button>

                        <button id="zoomOut" class="btn btn-light btn-sm">
                            <i class="bi bi-zoom-out"></i>
                        </button>

                        <button id="zoomReset" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>

                        <button id="fullscreenToggle" class="btn btn-light btn-sm">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>

                    </div>


                    <div id="zoom-wrapper" class="position-relative">
                        <div id="ebook-scale">
                            <div id="flipbook">

                                @if (!empty($pages) && isset($pages[0]))
                                    <div class="page cover">
                                        <img src="{{ $pages[0] }}" alt="Cover">
                                    </div>
                                @endif

                                @foreach ($pages as $index => $img)
                                    @if ($index !== 0)
                                        <div class="page">
                                            <img src="{{ $img }}" alt="Page {{ $index + 1 }}">
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>

                        <div class="ebook-side-nav">
                            <button class="side-btn prev" id="prevPage" type="button">
                                <img src="{{ asset('images/back.png') }}" alt="Previous">
                            </button>
                            <button class="side-btn next" id="nextPage" type="button">
                                <img src="{{ asset('images/share.png') }}" alt="Next">
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <audio id="flipSound" src="{{ asset('sound/page-flip-12.wav') }}" preload="auto"></audio>
    </div>
@endsection
