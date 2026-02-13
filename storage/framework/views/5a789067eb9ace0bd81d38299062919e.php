<!DOCTYPE html>
<html>

<head>
    <?php echo $__env->make('layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="<?php echo $__env->yieldContent('body-class', 'dashboard-page'); ?>">

    <?php
        $isEbookView = trim($__env->yieldContent('body-class')) === 'ebook-view';
    ?>

    <?php if (! ($isEbookView)): ?>
        
        <?php echo $__env->make('layout.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    
    <main class="<?php echo e($isEbookView ? 'py-0' : 'container py-4'); ?>">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('layout.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\ebook\resources\views/layout/app.blade.php ENDPATH**/ ?>