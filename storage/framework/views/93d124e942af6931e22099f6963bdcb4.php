<nav class="navbar navbar-expand-lg custom-navbar shadow-sm  mb-4">

    <div class="d-flex justify-content-between align-items-center w-100">

        <!-- Left -->
        <div class="d-flex align-items-center ms-4 fw-bold fs-5 text-dark">
            <button class="btn btn-sm btn-light me-2 d-md-none sidebar-toggle" type="button" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <img src="<?php echo e(asset('images/dashboard.png')); ?>" width="28" height="28" class="me-2">
            <span>Dashboard</span>
        </div>

        <!-- Right -->
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-flex align-items-center ms-auto gap-3">
            <?php echo csrf_field(); ?>

            <!-- Logged User -->
            <span class="navbar-text fw-semibold text-dark">

                <?php if(auth()->check()): ?>
                    <?php echo e(auth()->user()->name ?? (auth()->user()->serp_id ?? auth()->user()->email)); ?>

                <?php else: ?>
                    Guest
                <?php endif; ?>

            </span>

            <!-- Logout Button -->
            <div class="logout-box">
                <button type="submit" class="logout-btn" title="Logout">
                    <img src="<?php echo e(asset('images/logout.png')); ?>" width="32" height="32" alt="Logout">
                </button>
            </div>

        </form>

    </div>

</nav>
<?php /**PATH C:\xampp\htdocs\mini_project-main\mylaravelapp\resources\views/admin/partials/navbar.blade.php ENDPATH**/ ?>