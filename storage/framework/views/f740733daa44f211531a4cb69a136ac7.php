<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>

    <div class="page-heading mb-4">
        <h3>User Management Dashboard</h3>
        <p class="text-muted">Manage user upload and share permissions</p>
    </div>

    <div class="page-content admin-dashboard">

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
                <div class="card shadow-sm border-0 mb-4 admin-users-card">

                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">User Permission Management</h5>
                        <small>
                            Control upload and sharing limits
                        </small>
                    </div>


                    <div class="card-body p-0">

                        
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show m-3">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger alert-dismissible fade show m-3">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div><?php echo e($error); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>


                        <div class="table-responsive admin-users-table-wrap">
                            <table class="table table-striped table-hover align-middle text-center mb-0 admin-users-table">

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
                                    <?php
                                        $uploadLocked = $user->upload_limit_reached ?? false;
                                        $shareLocked = $user->share_limit_reached ?? false;
                                        $rowLocked = $uploadLocked || $shareLocked;
                                    ?>
                                    <tr>
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
                                                    id="can-upload-<?php echo e($user->id); ?>"
                                                    form="update-user-<?php echo e($user->id); ?>"
                                                    data-upload-limit-target="upload-limit-<?php echo e($user->id); ?>"
                                                    <?php echo e($uploadLocked ? 'disabled' : ''); ?>

                                                    <?php echo e($user->can_upload ? 'checked' : ''); ?>>
                                            </div>
                                        </td>

                                        <!-- Share -->
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" name="can_share"
                                                    id="can-share-<?php echo e($user->id); ?>"
                                                    form="update-user-<?php echo e($user->id); ?>"
                                                    data-share-limit-target="share-limit-<?php echo e($user->id); ?>"
                                                    <?php echo e($shareLocked ? 'disabled' : ''); ?>

                                                    <?php echo e($user->can_share ? 'checked' : ''); ?>>
                                            </div>
                                        </td>

                                        <!-- Upload Limit -->
                                        <td style="max-width:90px; <?php echo e($uploadLocked ? 'cursor:not-allowed;' : ''); ?>"
                                            <?php if($uploadLocked): ?> onclick="alert('Upload limit reached. Please use Reset Uploads first, then set a new upload limit.')" <?php endif; ?>>
                                            <input type="number" name="upload_limit" min="0"
                                                id="upload-limit-<?php echo e($user->id); ?>"
                                                form="update-user-<?php echo e($user->id); ?>"
                                                class="form-control form-control-sm text-center"
                                                <?php echo e($user->can_upload && !$uploadLocked ? '' : 'disabled'); ?>

                                                value="<?php echo e($user->upload_limit); ?>">
                                            <small class="d-block mt-1 text-muted">
                                                Used <?php echo e($user->upload_used ?? 0); ?> /
                                                <?php echo e((int) $user->upload_limit === 0 ? 'Unlimited' : (int) $user->upload_limit); ?>

                                            </small>
                                            <?php if($user->upload_limit_reached ?? false): ?>
                                                <span class="badge bg-danger mt-1">Upload Limit Reached</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Share Limit -->
                                        <td style="max-width:90px; <?php echo e($shareLocked ? 'cursor:not-allowed;' : ''); ?>"
                                            <?php if($shareLocked): ?> onclick="alert('Share limit reached. Please use Reset Shares first, then set a new share limit.')" <?php endif; ?>>
                                            <input type="number" name="share_limit" min="0"
                                                id="share-limit-<?php echo e($user->id); ?>"
                                                form="update-user-<?php echo e($user->id); ?>"
                                                class="form-control form-control-sm text-center"
                                                <?php echo e($user->can_share && !$shareLocked ? '' : 'disabled'); ?>

                                                value="<?php echo e($user->share_limit); ?>">
                                            <small class="d-block mt-1 text-muted">
                                                Used <?php echo e($user->share_used ?? 0); ?> /
                                                <?php echo e((int) $user->share_limit === 0 ? 'Unlimited' : (int) $user->share_limit); ?>

                                            </small>
                                            <?php if(($user->share_reached ?? 0) > 0): ?>
                                                <small class="d-block mt-1 text-danger fw-semibold">
                                                    Reached <?php echo e($user->share_reached); ?> link(s)
                                                </small>
                                            <?php endif; ?>
                                            <?php if($user->share_limit_reached ?? false): ?>
                                                <span class="badge bg-danger mt-1">Share Limit Reached</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="action-wrapper">
                                                <form id="update-user-<?php echo e($user->id); ?>" method="POST"
                                                    action="<?php echo e(route('admin.users.update', $user->id)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                </form>

                                                <!-- Save -->
                                                <?php if($rowLocked): ?>
                                                    <button type="button" class="btn btn-sm admin-action-btn admin-action-locked"
                                                        onclick="alert('Limit reached. Please use Reset Uploads / Reset Shares first, then set a new limit.')">
                                                        <i class="bi bi-lock me-1"></i>
                                                        Save
                                                    </button>
                                                <?php else: ?>
                                                    <button type="submit" form="update-user-<?php echo e($user->id); ?>"
                                                        class="btn btn-sm admin-action-btn admin-action-save">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        Save
                                                    </button>
                                                <?php endif; ?>

                                                <!-- Reset -->
                                                <form method="POST" action="<?php echo e(route('admin.users.resetUploads', $user->id)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm admin-action-btn admin-action-reset-upload"
                                                        onclick="return confirm('Reset all uploads for this user?');">
                                                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                                                        Reset Uploads
                                                    </button>
                                                </form>

                                                <form method="POST" action="<?php echo e(route('admin.users.resetShares', $user->id)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm admin-action-btn admin-action-reset-share"
                                                        onclick="return confirm('Reset all active shares for this user?');">
                                                        <i class="bi bi-link-45deg me-1"></i>
                                                        Reset Shares
                                                    </button>
                                                </form>

                                                <form method="POST" action="<?php echo e(route('admin.users.destroy', $user->id)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm admin-action-btn admin-action-delete"
                                                        onclick="return confirm('Delete this user and all related ebooks? This cannot be undone.');">
                                                        <i class="bi bi-trash me-1"></i>
                                                        Delete User
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
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

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadToggles = document.querySelectorAll('input[name="can_upload"][data-upload-limit-target]');
            const shareToggles = document.querySelectorAll('input[name="can_share"][data-share-limit-target]');

            const syncUploadLimitState = (toggle) => {
                const targetId = toggle.getAttribute('data-upload-limit-target');
                const limitInput = document.getElementById(targetId);

                if (!limitInput) return;
                limitInput.disabled = !toggle.checked;
            };

            const syncShareLimitState = (toggle) => {
                const targetId = toggle.getAttribute('data-share-limit-target');
                const limitInput = document.getElementById(targetId);

                if (!limitInput) return;
                limitInput.disabled = !toggle.checked;

                if (!toggle.checked) {
                    limitInput.value = 0;
                }
            };

            uploadToggles.forEach((toggle) => {
                syncUploadLimitState(toggle);
                toggle.addEventListener('change', () => syncUploadLimitState(toggle));
            });

            shareToggles.forEach((toggle) => {
                syncShareLimitState(toggle);
                toggle.addEventListener('change', () => syncShareLimitState(toggle));
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ebook\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>