<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.header')
</head>


<body>

    <div id="app">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        <div id="main">

            {{-- Navbar --}}
            @include('admin.partials.navbar')

            {{-- Page Content --}}
            <div class="page-content">
                @yield('content')
            </div>

            {{-- Footer --}}
            @include('admin.partials.footer')

        </div>

    </div>


    <script src="{{ asset('admin/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/dist/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/dist/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('admin/dist/assets/js/main.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        // Force reload when restored from BFCache (back/forward)
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

    @stack('scripts')

</body>

</html>
