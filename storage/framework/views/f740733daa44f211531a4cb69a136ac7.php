

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>

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
                                        <div class="fs-4 fw-bold"><?php echo e($totalUsers); ?></div>
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
                                        <div class="fs-4 fw-bold"><?php echo e($totalEbooks); ?></div>
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
                                        <div class="fs-4 fw-bold"><?php echo e($todayUploads); ?></div>
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
                                        <div class="fs-4 fw-bold"><?php echo e($expiredShares); ?></div>
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

                        
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>


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
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>">
                                            <?php echo csrf_field(); ?>


                                            <!-- Name -->
                                            <td class="fw-bold">
                                                <?php echo e($user->name); ?>

                                            </td>

                                            <!-- Email -->
                                            <td class="text-muted">
                                                <?php echo e($user->email); ?>

                                            </td>

                                            <!-- Role -->
                                            <td>
                                                <span class="badge bg-secondary px-3 py-2">
                                                    <?php echo e(ucfirst($user->role)); ?>

                                                </span>
                                            </td>


                                            <!-- Upload -->
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="can_upload"
                                                        <?php echo e($user->can_upload ? 'checked' : ''); ?>>
                                                </div>
                                            </td>


                                            <!-- Share -->
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input class="form-check-input" type="checkbox" name="can_share"
                                                        <?php echo e($user->can_share ? 'checked' : ''); ?>>
                                                </div>
                                            </td>


                                            <!-- Upload Limit -->
                                            <td style="max-width:90px">
                                                <input type="number" name="upload_limit" min="0"
                                                    class="form-control form-control-sm text-center"
                                                    value="<?php echo e($user->upload_limit); ?>">
                                            </td>


                                            <!-- Share Limit -->
                                            <td style="max-width:90px">
                                                <input type="number" name="share_limit" min="0"
                                                    class="form-control form-control-sm text-center"
                                                    value="<?php echo e($user->share_limit); ?>">
                                            </td>

                                            
                                            <td>
                                                <div class="d-flex flex-column gap-2 align-items-start">

                                                    <!-- Save -->
                                                    <button type="submit" class="btn btn-sm btn-success px-3">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Save
                                                    </button>

                                                    <!-- Reset -->
                                                    <button type="submit" class="btn btn-sm btn-warning px-3"
                                                        formaction="<?php echo e(route('admin.users.resetUploads', $user->id)); ?>"
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
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>

                            </table>

                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($users->links('pagination::bootstrap-5')); ?>

                        </div>

                    </div>

                </div>
                <!-- End User Permission Management -->


            </div>

        </section>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ebook\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>