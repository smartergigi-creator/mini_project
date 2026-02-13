<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- StPageFlip -->
<script src="<?php echo e(asset('js/stflip.js')); ?>"></script>

<!-- Main Script -->
<script src="<?php echo e(asset('js/script.js')); ?>"></script>
<script src="<?php echo e(asset('js/auth.js')); ?>"></script>

<?php
    $isEbookView = trim($__env->yieldContent('body-class')) === 'ebook-view';
?>

<?php if (! ($isEbookView)): ?>
    <footer>
        <div class="footer clearfix mb-0 text-muted">

            <div class="float-start">
                <p><?php echo e(date('Y')); ?> Â© Ebook</p>
            </div>


            <div class="float-end">
                <p>Powered by Smarter India</p>
            </div>

        </div>
    </footer>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ebook\resources\views/layout/footer.blade.php ENDPATH**/ ?>