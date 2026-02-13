<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- StPageFlip -->
<script src="{{ asset('js/stflip.js') }}"></script>

<!-- Main Script -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/auth.js') }}"></script>

@php
    $isEbookView = trim($__env->yieldContent('body-class')) === 'ebook-view';
@endphp

@unless ($isEbookView)
    <footer>
        <div class="footer clearfix mb-0 text-muted">

            <div class="float-start">
                <p>{{ date('Y') }} Â© Ebook</p>
            </div>


            <div class="float-end">
                <p>Powered by Smarter India</p>
            </div>

        </div>
    </footer>
@endunless
