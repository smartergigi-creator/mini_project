<?php $__env->startSection('title', 'Flipbook'); ?>
<?php $__env->startSection('body-class', 'ebook-view'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid vh-100 d-flex flex-column">

        <div class="row">
            <div class="col-12 text-start py-2">
                <a href="<?php echo e(url('/home#ebooksSection')); ?>" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i>Back
                </a>


                <h2 class="title mb-0"><?php echo e($ebook->title); ?></h2>
            </div>
        </div>

        <div class="row flex-grow-1">
            <div class="col-12 d-flex justify-content-center align-items-start">
                <div id="viewer-wrapper" class="mb-3">

                    <div class="viewer-toolbar position-absolute top-0 end-0 m-3 d-flex gap-2">

                        <button id="zoomIn" class="btn btn-light btn-sm">
                            <i class="bi bi-zoom-in"></i>
                        </button>

                        <button id="zoomOut" class="btn btn-light btn-sm">
                            <i class="bi bi-zoom-out"></i>
                        </button>

                        <button id="zoomReset" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>

                        <button id="fullscreenToggle" class="btn btn-light btn-sm">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>

                    </div>


                    <div id="zoom-wrapper" class="position-relative">
                        <div id="ebook-scale">
                            <div id="flipbook">

                                <?php if(!empty($pages) && isset($pages[0])): ?>
                                    <div class="page cover">
                                        <img src="<?php echo e($pages[0]); ?>" alt="Cover">
                                    </div>
                                <?php endif; ?>

                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($index !== 0): ?>
                                        <div class="page">
                                            <img src="<?php echo e($img); ?>" alt="Page <?php echo e($index + 1); ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </div>

                        <div class="ebook-side-nav">
                            <button class="side-btn prev" id="prevPage" type="button">
                                <img src="<?php echo e(asset('images/back.png')); ?>" alt="Previous">
                            </button>
                            <button class="side-btn next" id="nextPage" type="button">
                                <img src="<?php echo e(asset('images/share.png')); ?>" alt="Next">
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <audio id="flipSound" src="<?php echo e(asset('sound/page-flip-12.wav')); ?>" preload="auto"></audio>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ebook\resources\views/ebook/flipbook.blade.php ENDPATH**/ ?>