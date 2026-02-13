<!DOCTYPE html>
<html lang="en">

<head>

    <?php echo $__env->make('layout.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <title>Login</title>

    <!-- Only for Login Page -->
    <link rel="stylesheet" href="<?php echo e(asset('css/auth.css')); ?>">

</head>

<body>

    <div class="container">

        <!-- LEFT IMAGE PANEL -->
        <div class="left"></div>

        <!-- RIGHT FORM PANEL -->
        <div class="right">

            <div class="form-box">

                <h2>Login</h2>

                <?php if(session('error')): ?>
                    <p class="error"><?php echo e(session('error')); ?></p>
                <?php endif; ?>

                <!-- SERP LOGIN FORM -->
                <form method="POST" action="<?php echo e(url('/serp-login')); ?>">
                    <?php echo csrf_field(); ?>

                    <input type="text" name="username" placeholder="ERP ID" required>

                    <input type="password" name="password" placeholder="Password" required>

                    <button type="submit">
                        Login
                    </button>
                </form>

            </div>

        </div>

    </div>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\ebook\resources\views/auth/login.blade.php ENDPATH**/ ?>