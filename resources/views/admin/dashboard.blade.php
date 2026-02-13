@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')

    <div class="page-heading mb-4">
        <h3>User Management Dashboard</h3>
        <p class="text-muted">Manage user upload and share permissions</p>
    </div>

    <div class="page-content">

        <section class="row justify-content-center">

            <div class="col-12">

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 stat-card stat-users">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small">Total Users</div>
                                        <div class="fs-4 fw-bold">{{ $totalUsers }}</div>
                                    </div>
                                    <i class="bi bi-people fs-2 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 stat-card stat-ebooks">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small">Total Ebooks</div>
                                        <div class="fs-4 fw-bold">{{ $totalEbooks }}</div>
                                    </div>
                                    <i class="bi bi-book fs-2 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 stat-card stat-uploads">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small">Today Uploads</div>
                                        <div class="fs-4 fw-bold">{{ $todayUploads }}</div>
                                    </div>
                                    <i class="bi bi-cloud-upload fs-2 text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 stat-card stat-expired">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted small">Expired Shares</div>
                                        <div class="fs-4 fw-bold">{{ $expiredShares }}</div>
                                    </div>
                                    <i class="bi bi-hourglass-split fs-2 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- User Permission Management -->
                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-people-fill me-2"></i>
                            User Permission Management
                        </h4>
                        <small class="opacity-75">
                            Control upload and sharing limits
                        </small>
                    </div>


                    <div class="card-body">

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif


                        <div class="table-responsive">

                            <table class="table table-striped table-hover align-middle text-center">

                                <thead class="table-light">
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Upload</th>
                                        <th>Share</th>
                                        <th>Upload Limit</th>
                                        <th>Share Limit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                                            @csrf


                                            <!-- Name -->
                                            <td class="fw-bold">
                                                {{ $user->name }}
                                            </td>

                                            <!-- Email -->
                                            <td class="text-muted">
                                                {{ $user->email }}
                                            </td>

                                            <!-- Role -->
                                            <td>
                                                <span class="badge bg-secondary px-3 py-2">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>


                                            <!-- Upload -->
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="can_upload"
                                                        {{ $user->can_upload ? 'checked' : '' }}>
                                                </div>
                                            </td>


                                            <!-- Share -->
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="can_share"
                                                        {{ $user->can_share ? 'checked' : '' }}>
                                                </div>
                                            </td>


                                            <!-- Upload Limit -->
                                            <td style="max-width:90px">
                                                <input type="number" name="upload_limit" min="0"
                                                    class="form-control form-control-sm text-center"
                                                    value="{{ $user->upload_limit }}">
                                            </td>


                                            <!-- Share Limit -->
                                            <td style="max-width:90px">
                                                <input type="number" name="share_limit" min="0"
                                                    class="form-control form-control-sm text-center"
                                                    value="{{ $user->share_limit }}">
                                            </td>

                                            {{-- save --}}
                                            <td>
                                                <div class="d-flex flex-column gap-2 align-items-start">

                                                    <!-- Save -->
                                                    <button type="submit" class="btn btn-sm btn-success px-3">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Save
                                                    </button>

                                                    <!-- Reset -->
                                                    <button type="submit" class="btn btn-sm btn-warning px-3"
                                                        formaction="{{ route('admin.users.resetUploads', $user->id) }}"
                                                        formmethod="POST"
                                                        onclick="return confirm('Reset all uploads for this user?');">

                                                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                                                        Reset Uploads
                                                    </button>

                                                    <!-- Warning -->
                                                    <small class="text-danger">
                                                        ⚠️ Deletes all ebooks and data.<br>
                                                        Use only for testing/maintenance.
                                                    </small>

                                                </div>
                                            </td>



                                        </form>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>

                    </div>

                </div>
                <!-- End User Permission Management -->


            </div>

        </section>

    </div>

@endsection
