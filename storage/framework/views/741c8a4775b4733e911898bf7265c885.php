

<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('body-class', 'ebook-home'); ?>

<?php $__env->startSection('content'); ?>




    
    <section class="home-hero">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6">
                    <h1>Explore Your eBook Library</h1>
                    <p>Upload, manage and share flipbooks easily.</p>

                    <a href="#ebooksSection" class="btn btn-info mt-3">
                        Browse eBooks →
                    </a>
                </div>

                <div class="col-lg-6 text-center">
                    <img src="<?php echo e(asset('images/homepage.png')); ?>" alt="Hero">
                </div>


            </div>
        </div>
    </section>



    
    <div class="container mt-5" id="ebooksSection">

        <div class="home-toolbar">

            <form method="GET" class="row g-3">

                <div class="col-md-4">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control"
                        placeholder="Search ebooks...">
                </div>

                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                                <?php echo e($cat->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-dark w-100">
                        Filter
                    </button>
                </div>

            </form>

        </div>



        
        <div class="row mt-4">

            <?php $__empty_1 = true; $__currentLoopData = $ebooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ebook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-3 mb-4">

                    <div class="ebook-card">

                        <a href="<?php echo e(url('/ebook/view/' . $ebook->id)); ?>">
                            <img src="<?php echo e(asset('storage/' . $ebook->thumbnail)); ?>" class="ebook-img"
                                alt="<?php echo e($ebook->title); ?>">
                        </a>

                        <div class="ebook-body">
                            <h6><?php echo e($ebook->title); ?></h6>
                            <small>
                                <?php echo e($ebook->created_at->format('d M Y')); ?>

                            </small>
                        </div>

                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="col-12 text-center">
                    <p>No ebooks found.</p>
                </div>
            <?php endif; ?>

        </div>

        
        <div class="mt-4">
            <?php echo e($ebooks->links()); ?>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ebook\resources\views/ebook/home.blade.php ENDPATH**/ ?>