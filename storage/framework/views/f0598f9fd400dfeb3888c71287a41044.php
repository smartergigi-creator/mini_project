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
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php
                $homeUrl = url('/home');
                $homeSectionUrl = url('/home#ebooksSection');
                $menuCategories = isset($categories)
                    ? $categories
                    : \App\Models\Category::whereNull('parent_id')
                        ->with([
                            'children' => fn($query) => $query->orderBy('name'),
                            'children.children' => fn($query) => $query->orderBy('name'),
                        ])
                        ->orderBy('name')
                        ->get();
            ?>

            <ul class="navbar-nav ms-4 align-items-center">


                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->is('home') ? 'active' : ''); ?>" href="<?php echo e($homeUrl); ?>">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e($homeSectionUrl); ?>">Ebooks</a>
                </li>

                <?php $__currentLoopData = $menuCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($menuCategory->children->isEmpty()): ?>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?php echo e($homeUrl); ?>?category=<?php echo e($menuCategory->id); ?>#ebooksSection"><?php echo e($menuCategory->name); ?></a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <?php echo e($menuCategory->name); ?>

                            </a>

                            <ul
                                class="dropdown-menu <?php echo e($menuCategory->children->count() > 10 ? 'dropdown-menu-columns' : ''); ?>">
                                <li>
                                    <a class="dropdown-item"
                                        href="<?php echo e($homeUrl); ?>?category=<?php echo e($menuCategory->id); ?>#ebooksSection">
                                        All <?php echo e($menuCategory->name); ?>

                                    </a>
                                </li>

                                <?php $__currentLoopData = $menuCategory->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuSubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($menuSubcategory->children->isEmpty()): ?>
                                        <li>
                                            <a class="dropdown-item"
                                                href="<?php echo e($homeUrl); ?>?category=<?php echo e($menuCategory->id); ?>&subcategory=<?php echo e($menuSubcategory->id); ?>#ebooksSection">
                                                <?php echo e($menuSubcategory->name); ?>

                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="dropdown-submenu position-relative">
                                            <a class="dropdown-item dropdown-toggle"
                                                href="<?php echo e($homeUrl); ?>?category=<?php echo e($menuCategory->id); ?>&subcategory=<?php echo e($menuSubcategory->id); ?>#ebooksSection">
                                                <?php echo e($menuSubcategory->name); ?>

                                            </a>
                                            <ul class="dropdown-menu position-absolute start-100 top-0">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e($homeUrl); ?>?category=<?php echo e($menuCategory->id); ?>&subcategory=<?php echo e($menuSubcategory->id); ?>#ebooksSection">
                                                        All <?php echo e($menuSubcategory->name); ?>

                                                    </a>
                                                </li>
                                                <?php $__currentLoopData = $menuSubcategory->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuRelatedSubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="<?php echo e($homeUrl); ?>?category=<?php echo e($menuCategory->id); ?>&subcategory=<?php echo e($menuSubcategory->id); ?>&related_subcategory=<?php echo e($menuRelatedSubcategory->id); ?>#ebooksSection">
                                                            <?php echo e($menuRelatedSubcategory->name); ?>

                                                        </a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




            </ul>

        </div>

        <!-- Right Side -->
        <div class="d-flex align-items-center gap-2">

            <span class="user-name">
                <?php if(auth()->check()): ?>
                    <?php echo e(auth()->user()->name ?? auth()->user()->email); ?>

                <?php else: ?>
                    Guest!
                <?php endif; ?>
            </span>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="logout-btn">
                    <img src="<?php echo e(asset('images/logout.png')); ?>" alt="Logout">
                </button>
            </form>

        </div>


    </div>

</nav>
<?php /**PATH C:\xampp\htdocs\ebook\resources\views/layout/navbar.blade.php ENDPATH**/ ?>