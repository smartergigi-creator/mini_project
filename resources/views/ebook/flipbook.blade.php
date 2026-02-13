@extends('layout.app')

@section('content')
@section('body-class', 'ebook-view')

<a href="{{ route('admin.ebooks') }}" class="ebook-back-btn">← Back</a>


{{-- LOADER --}}
<div id="ebookLoader">
    <div class="loader-box">
        <div class="spinner"></div>
        <p>Loading ebookâ€¦</p>
    </div>
</div>


{{-- ===============================
   VIEWER
=============================== --}}
<div id="viewer-wrapper">

    {{-- TOOLBAR --}}
    <div class="viewer-toolbar">
        <button id="tocBtn">☰</button> <!-- Menu -->
        <button id="zoomIn">＋</button> <!-- Zoom In -->
        <button id="zoomOut">－</button> <!-- Zoom Out -->
        <button id="zoomReset">⟳</button> <!-- Reset -->
        <button id="fullscreenToggle">⛶</button> <!-- Fullscreen -->
    </div>



    {{-- FLIPBOOK --}}
    <div id="flipbook">

        {{-- COVER PAGE --}}
        @if (isset($pages[0]))
            <div class="page cover" data-density="soft">
                <img src="{{ $pages[0] }}" alt="Cover">
            </div>
        @endif


        {{-- INNER PAGES --}}
        @foreach ($pages as $i => $img)
            @if ($i !== 0)
                <div class="page">
                    <img src="{{ $img }}" alt="Page {{ $i + 1 }}">
                </div>
            @endif
        @endforeach

    </div>


    {{-- SIDE NAV --}}
    <div class="ebook-side-nav">

        <button class="side-btn prev" id="prevPage">
            <img src="{{ asset('images/back.png') }}" alt="Previous">
        </button>

        <button class="side-btn next" id="nextPage">
            <img src="{{ asset('images/share.png') }}" alt="Next">
        </button>

    </div>

</div>
{{-- ===== END viewer-wrapper ===== --}}



{{-- ===============================
   TABLE OF CONTENTS (OUTSIDE)
=============================== --}}
<div id="tocPanel">

    <div class="toc-header">
        <span>Table of Contents</span>
        <button id="closeToc">âœ–</button>
    </div>

    {{-- <div id="tocList">

        @foreach ($pages as $i => $img)
            <div class="toc-item" data-page="{{ $i }}">
                Page {{ str_pad($i+1, 3, '0', STR_PAD_LEFT) }}
            </div>
        @endforeach

    </div> --}}
    <div id="tocList">

        @foreach ($pages as $i => $img)
            <div class="toc-item" data-page="{{ $i }}" data-num="{{ $i + 1 }}">
                Page {{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}
            </div>
        @endforeach

    </div>


</div>



{{-- AUDIO --}}
<audio id="flipSound" src="{{ asset('sound/page-flip-12.wav') }}" preload="auto"></audio>

@endsection
