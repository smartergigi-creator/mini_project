<nav class="navbar navbar-expand-lg custom-navbar shadow-sm  mb-4">

    <div class="d-flex justify-content-between align-items-center w-100">

        <!-- Left -->
        <div class="d-flex align-items-center ms-4 fw-bold fs-5 text-dark">
            <img src="{{ asset('images/dashboard.png') }}" width="28" height="28" class="me-2">
            <span>Dashboard</span>
        </div>

        <!-- Right -->
        <form method="POST" action="{{ route('logout') }}" class="d-flex align-items-center ms-auto gap-3">
            @csrf

            <!-- Logged User -->
            <span class="navbar-text fw-semibold text-dark">

                @if (auth()->check())
                    {{ auth()->user()->name ?? (auth()->user()->serp_id ?? auth()->user()->email) }}
                @else
                    Guest
                @endif

            </span>

            <!-- Logout Button -->
            <div class="logout-box">
                <button type="submit" class="logout-btn" title="Logout">
                    <img src="{{ asset('images/logout.png') }}" width="32" height="32" alt="Logout">
                </button>
            </div>

        </form>

    </div>

</nav>
