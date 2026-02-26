@extends('layout.app')

@section('title', 'Flipbook')
@section('body-class', 'ebook-view')

@section('content')
    <div class="container-fluid vh-100 d-flex flex-column">

        <div class="row">
            <div class="col-12 text-start py-2">
                <a href="{{ url('/home#ebooksSection') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i>Back
                </a>


                <h2 class="title mb-0">{{ $ebook->title }}</h2>
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
                            </div>
                        </div>

                        <div class="ebook-side-nav">
                            <button class="side-btn prev" id="prevPage" type="button">
                                <img src="{{ asset('images/back.png') }}" alt="Previous">
                            </button>
                            <button class="side-btn next" id="nextPage" type="button">
                                <img src="{{ asset('images/share.png') }}" alt="Next">
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <audio id="flipSound" src="{{ asset('sound/page-flip-12.wav') }}" preload="auto"></audio>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        (function() {
            const flipbook = document.getElementById('flipbook');
            const pdfUrl = @json(asset($ebook->pdf_path));

            if (!flipbook || !window.pdfjsLib || !pdfUrl) {
                return;
            }

            // Let existing flipbook script wait for this promise before init.
            window.__PDF_PAGES_READY_PROMISE__ = (async () => {
                pdfjsLib.GlobalWorkerOptions.workerSrc =
                    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

                const pdf = await pdfjsLib.getDocument(pdfUrl).promise;

                for (let i = 1; i <= pdf.numPages; i++) {
                    const page = await pdf.getPage(i);
                    const viewport = page.getViewport({
                        scale: 1.5
                    });

                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = Math.floor(viewport.width);
                    canvas.height = Math.floor(viewport.height);

                    await page.render({
                        canvasContext: ctx,
                        viewport
                    }).promise;

                    const wrapper = document.createElement('div');
                    wrapper.className = i === 1 ? 'page cover' : 'page';

                    const img = document.createElement('img');
                    img.src = canvas.toDataURL('image/jpeg', 0.9);
                    img.alt = 'Page ' + i;
                    wrapper.appendChild(img);

                    flipbook.appendChild(wrapper);
                }
            })();
        })();
    </script>
@endsection
