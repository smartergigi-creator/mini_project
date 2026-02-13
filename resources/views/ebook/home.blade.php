@extends('layout.app')

@section('title', 'Home')
@section('body-class', 'ebook-home')

@section('content')




    {{-- ===============================
   HERO SECTION
=============================== --}}
    <section class="home-hero">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6">
                    <h1>Explore Your eBook Library</h1>
                    <p>Upload, manage and share flipbooks easily.</p>

                    <a href="#ebooksSection" class="btn btn-info mt-3">
                        Browse eBooks →
                    </a>
                </div>

                <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/homepage.png') }}" alt="Hero">
                </div>


            </div>
        </div>
    </section>



    {{-- ===============================
   FILTER BAR
=============================== --}}
    <div class="container mt-5" id="ebooksSection">

        <div class="home-toolbar">

            <form method="GET" class="row g-3">

                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Search ebooks...">
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-dark w-100">
                        Filter
                    </button>
                </div>

            </form>

        </div>



        {{-- ===============================
       EBOOK GRID
    =============================== --}}
        <div class="row mt-4">

            @forelse($ebooks as $ebook)
                <div class="col-md-3 mb-4">

                    <div class="ebook-card">

                        <a href="{{ url('/ebook/view/' . $ebook->id) }}">
                            <img src="{{ asset('storage/' . $ebook->thumbnail) }}" class="ebook-img"
                                alt="{{ $ebook->title }}">
                        </a>

                        <div class="ebook-body">
                            <h6>{{ $ebook->title }}</h6>
                            <small>
                                {{ $ebook->created_at->format('d M Y') }}
                            </small>
                        </div>

                    </div>

                </div>
            @empty

                <div class="col-12 text-center">
                    <p>No ebooks found.</p>
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $ebooks->links() }}
        </div>

    </div>

@endsection
