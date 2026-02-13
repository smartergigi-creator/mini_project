<!DOCTYPE html>
<html>

<head>
    @include('layout.header')
</head>

<body class="@yield('body-class', 'dashboard-page')">

    @php
        $isEbookView = trim($__env->yieldContent('body-class')) === 'ebook-view';
    @endphp

    @unless ($isEbookView)
        {{-- User Navbar --}}
        @include('layout.navbar')
    @endunless

    {{-- Page Content --}}
    <main class="{{ $isEbookView ? 'py-0' : 'container py-4' }}">
        @yield('content')
    </main>

    {{-- Footer + Scripts --}}
    @include('layout.footer')

</body>

</html>
