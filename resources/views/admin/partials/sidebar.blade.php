<div id="sidebar" class="sidebar active">

    <div class="sidebar-wrapper">


        <!-- Header -->
        <div class="sidebar-header">

            <div class="d-flex justify-content-between align-items-center">

                <!-- Logo -->
                <div class="logo">
                    <img style="width:80px; height:auto;" src="{{ asset('admin/dist/assets/images/logo/logo.png') }}">
                </div>

                <!-- Mobile Close Button -->
                <button class="btn btn-sm btn-light d-md-none sidebar-toggle" type="button" aria-label="Close sidebar">
                    <i class="bi bi-x-lg"></i>
                </button>

                <!-- Desktop Toggle Button -->
                <button class="btn btn-sm btn-info d-none d-md-inline-flex sidebar-toggle-desktop" type="button"
                    aria-label="Toggle sidebar collapse">
                    <i class="bi bi-list"></i>
                </button>


            </div>

        </div>


        <!-- Menu -->
        <div class="sidebar-menu">

            <ul class="menu">

                <li class="sidebar-title">Menu</li>


                @auth

                    {{-- ✅ Admin Only --}}
                    @if (auth()->user()->role === 'admin')
                        <!-- Dashboard -->
                        <li class="sidebar-item {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endif


                    {{-- ✅ Admin + User (Both can see) --}}

                        <li class="sidebar-item {{ request()->is('admin/ebooks*') ? 'active' : '' }}">
                        <a href="{{ route('admin.ebooks') }}" class="sidebar-link">
                            <i class="bi bi-book"></i>
                            <span>Ebooks</span>
                        </a>
                    </li>


                    {{-- ✅ All Users --}}
                    <li class="sidebar-item">
                        <a href="{{ route('logout') }}" class="sidebar-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </li>

                @endauth

            </ul>

        </div>

    </div>

</div>
