<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $__env->make('admin.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>


<body>

    <div id="app">

        
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div id="main">

            
            <?php echo $__env->make('admin.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            
            <div class="page-content">
                <?php echo $__env->yieldContent('content'); ?>
            </div>

            
            <?php echo $__env->make('admin.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>

    </div>


    <script src="<?php echo e(asset('admin/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/dist/assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/dist/assets/vendors/apexcharts/apexcharts.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/dist/assets/js/main.js')); ?>"></script>
    <script src="<?php echo e(asset('js/script.js')); ?>"></script>

    <script>
        // Force reload when restored from BFCache (back/forward)
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\mini_project-main\mylaravelapp\resources\views/admin/layout.blade.php ENDPATH**/ ?>