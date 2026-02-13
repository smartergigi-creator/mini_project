

<?php $__env->startSection('content'); ?>
    <!-- ================= HERO SECTION ================= -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6">
                    <h1 class="hero-title">
                        Explore Your eBook Library
                    </h1>
                    <p class="hero-subtitle">
                        Upload, manage and share flipbooks easily.
                    </p>
                </div>

                <div class="col-lg-6 text-center">
                    <img src="<?php echo e(asset('images/ebook-hero.png')); ?>" class="hero-img" alt="Ebook Illustration">
                </div>

            </div>
        </div>
    </section>


    <!-- ================= FILTER SECTION ================= -->
    <div class="container mt-5">

        <form method="GET" class="row mb-4">

            <!-- Search -->
            <div class="col-md-4 mb-2">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control"
                    placeholder="Search ebooks...">
            </div>

            <!-- Category -->
            <div class="col-md-3 mb-2">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                            <?php echo e($cat->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Button -->
            <div class="col-md-2 mb-2">
                <button class="btn btn-primary w-100">
                    Filter
                </button>
            </div>

        </form>


        <!-- ================= EBOOK GRID ================= -->
        <div class="row">

            <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-3 mb-4">
                    <div class="ebook-card">

                        <img src="<?php echo e(asset('storage/' . $ebook->thumbnail)); ?>" class="ebook-img" alt="<?php echo e($ebook->title); ?>">

                        <div class="ebook-body">
                            <h6 class="ebook-title">
                                <?php echo e($ebook->title); ?>

                            </h6>

                            <small class="text-muted">
                                <?php echo e($ebook->created_at->format('d M Y')); ?>

                            </small>

                            <div class="mt-2">
                                <a href="<?php echo e(url('/ebook/view/' . $ebook->id)); ?>"
                                    class="btn btn-sm btn-outline-primary w-100">
                                    View
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="col-12 text-center mt-5">
                    <h5>No ebooks found.</h5>
                </div>
            <?php endif; ?>

        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?php echo e($ebooks->links()); ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ebook\resources\views/user/home.blade.php ENDPATH**/ ?>