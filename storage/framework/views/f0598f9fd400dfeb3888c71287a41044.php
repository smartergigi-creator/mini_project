<nav class="navbar navbar-expand-lg nova-navbar fixed-top">


    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="#">

            <img src="<?php echo e(asset('admin/dist/assets/images/logo/logo.png')); ?>" width="60" alt="">



            <span class="brand-text">eBook</span>
        </a>

        <!-- Toggle (Mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">

            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link active" href="">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#ebooksSection">Ebooks</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Categories</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>

            </ul>

        </div>

        <!-- Right Side -->
        <div class="d-flex align-items-center gap-3">

            <span class="user-name">
                <?php if(auth()->check()): ?>
                    <?php echo e(auth()->user()->name ?? auth()->user()->email); ?>

                <?php else: ?>
                    Guest
                <?php endif; ?>
            </span>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="logout-btn"> <img src="<?php echo e(asset('images/logout.png')); ?>" class="hero-img" alt="Hero">
                </button>
            </form>

        </div>

    </div>

</nav>
<?php /**PATH C:\xampp\htdocs\ebook\resources\views/layout/navbar.blade.php ENDPATH**/ ?>