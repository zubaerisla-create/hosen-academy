@extends('layouts.default')

@section('content')
<section class="secure-ebook-reader-section bg-slate-900 min-vh-100 position-relative select-none">
    
    <!-- TOP TOOLBAR -->
    <div class="reader-top-bar bg-slate-950 border-bottom border-slate-800 py-2 px-3 sticky-top z-index-1050">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap gap-2">
            
            <!-- Left: Back & Title -->
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('my.ebooks') }}" class="btn btn-outline-slate text-slate-300 btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> {{ get_phrase('My eBooks') }}
                </a>
                <div class="lh-sm">
                    <h6 class="text-white fw-bold mb-0 text-truncate max-w-md fs-15">{{ $ebook->title }}</h6>
                    <span class="badge bg-emerald-500-subtle text-emerald-400 fs-11 py-0 px-2 fw-semibold">
                        <i class="fa-solid fa-shield-halved me-1"></i> {{ get_phrase('Protected Web Reader') }}
                    </span>
                </div>
            </div>

            <!-- Middle: Page Navigation Controls -->
            <div class="d-flex align-items-center gap-2 bg-slate-900 border border-slate-800 rounded-pill px-3 py-1">
                <button type="button" id="prev-page" class="btn btn-icon-slate text-slate-300 p-0 fs-14" title="Previous Page">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <div class="d-flex align-items-center gap-1 fs-13 text-slate-300 font-mono">
                    <span>Page</span>
                    <input type="number" id="page-num-input" value="1" min="1" class="form-control form-control-sm text-center bg-slate-950 text-white border-slate-800 px-1 py-0 font-mono fw-bold" style="width: 44px; height: 26px;">
                    <span>/ <span id="page-count">--</span></span>
                </div>
                <button type="button" id="next-page" class="btn btn-icon-slate text-slate-300 p-0 fs-14" title="Next Page">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

            <!-- Right: Zoom Controls & Fullscreen -->
            <div class="d-flex align-items-center gap-2">
                <div class="btn-group border border-slate-800 rounded-pill p-1 bg-slate-900">
                    <button type="button" id="zoom-out" class="btn btn-icon-slate text-slate-300 btn-sm px-2 py-0" title="Zoom Out">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span id="zoom-val" class="fs-12 text-slate-300 font-mono align-self-center px-1">100%</span>
                    <button type="button" id="zoom-in" class="btn btn-icon-slate text-slate-300 btn-sm px-2 py-0" title="Zoom In">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <button type="button" id="zoom-fit" class="btn btn-icon-slate text-slate-300 btn-sm px-2 py-0" title="Fit Width">
                        <i class="fa-solid fa-expand"></i>
                    </button>
                </div>

                <button type="button" id="fullscreen-toggle" class="btn btn-outline-slate text-slate-300 btn-sm rounded-circle p-2" title="Toggle Fullscreen">
                    <i class="fa-solid fa-maximize"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- MAIN CANVAS READER VIEWPORT -->
    <div id="reader-container" class="reader-viewport position-relative overflow-auto d-flex justify-content-center py-4 px-2 min-vh-90">
        
        <!-- Loading Spinner -->
        <div id="reader-loader" class="text-center my-auto py-5">
            <div class="spinner-border text-indigo mb-3" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading eBook...</span>
            </div>
            <h6 class="text-white fw-bold mb-1">{{ get_phrase('Loading Secure eBook Reader...') }}</h6>
            <p class="text-slate-400 fs-13 mb-0">{{ get_phrase('Verifying purchase & rendering high-quality pages') }}</p>
        </div>

        <!-- HTML5 Canvas Page Target -->
        <div id="canvas-wrapper" class="position-relative shadow-2xl rounded-12 overflow-hidden d-none bg-white">
            <canvas id="pdf-canvas" class="d-block"></canvas>

            <!-- Subtle Security Watermark -->
            <div class="security-watermark-overlay pe-none select-none">
                <div class="watermark-text">
                    {{ auth()->user()->name }} • {{ auth()->user()->email }} • Hosen Academy Licensed Reader
                </div>
            </div>
        </div>

    </div>

</section>

<!-- PDF.JS LIBRARY FROM CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<style>
.select-none {
    user-select: none !important;
    -webkit-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
}

.reader-top-bar {
    background-color: #020617 !important;
}

.btn-outline-slate {
    border: 1px solid #334155;
    background: #0f172a;
}
.btn-outline-slate:hover {
    background: #1e293b;
    color: #ffffff !important;
}

.btn-icon-slate {
    background: transparent;
    border: none;
    transition: color 0.15s ease;
}
.btn-icon-slate:hover {
    color: #38bdf8 !important;
}

.reader-viewport {
    background-color: #0f172a;
    min-height: calc(100vh - 60px);
}

#canvas-wrapper {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
}

.security-watermark-overlay {
    position: absolute;
    inset: 0;
    pointer-events: none;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    z-index: 10;
}

.watermark-text {
    transform: rotate(-30deg);
    font-size: 16px;
    font-weight: 700;
    color: rgba(15, 23, 42, 0.07);
    white-space: nowrap;
    letter-spacing: 2px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pdfUrl = "{{ $stream_url }}";

    // Set PDF.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    let pdfDoc = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    let scale = 1.25;

    const canvas = document.getElementById('pdf-canvas');
    const ctx = canvas.getContext('2d');
    const loader = document.getElementById('reader-loader');
    const wrapper = document.getElementById('canvas-wrapper');
    const pageNumInput = document.getElementById('page-num-input');
    const pageCountEl = document.getElementById('page-count');
    const zoomValEl = document.getElementById('zoom-val');

    // 1. Render Specific Page onto Canvas
    function renderPage(num) {
        pageRendering = true;

        pdfDoc.getPage(num).then(function (page) {
            const viewport = page.getViewport({ scale: scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            const renderTask = page.render(renderContext);

            renderTask.promise.then(function () {
                pageRendering = false;
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });

        pageNumInput.value = num;
        zoomValEl.textContent = Math.round(scale * 100) + '%';
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function onPrevPage() {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    }

    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    }

    // 2. Load PDF Document via Backend Stream Route
    pdfjsLib.getDocument({
        url: pdfUrl,
        withCredentials: true
    }).promise.then(function (pdfDoc_) {
        pdfDoc = pdfDoc_;
        pageCountEl.textContent = pdfDoc.numPages;

        loader.classList.add('d-none');
        wrapper.classList.remove('d-none');

        renderPage(pageNum);
    }).catch(function (error) {
        console.error('Error loading PDF:', error);
        loader.innerHTML = `
            <div class="alert alert-danger max-w-md mx-auto rounded-16 p-4 text-center">
                <i class="fa-solid fa-circle-exclamation fs-2 mb-2"></i>
                <h6 class="fw-bold mb-1">Unable to Load eBook Document</h6>
                <p class="fs-13 mb-0">Please verify your purchase or refresh the page.</p>
            </div>
        `;
    });

    // Event Listeners
    document.getElementById('prev-page').addEventListener('click', onPrevPage);
    document.getElementById('next-page').addEventListener('click', onNextPage);

    pageNumInput.addEventListener('change', function () {
        let val = parseInt(this.value);
        if (val >= 1 && val <= pdfDoc.numPages) {
            pageNum = val;
            queueRenderPage(pageNum);
        } else {
            this.value = pageNum;
        }
    });

    document.getElementById('zoom-in').addEventListener('click', function () {
        if (scale >= 3.0) return;
        scale += 0.25;
        queueRenderPage(pageNum);
    });

    document.getElementById('zoom-out').addEventListener('click', function () {
        if (scale <= 0.5) return;
        scale -= 0.25;
        queueRenderPage(pageNum);
    });

    document.getElementById('zoom-fit').addEventListener('click', function () {
        const containerWidth = document.getElementById('reader-container').clientWidth - 40;
        pdfDoc.getPage(pageNum).then(function (page) {
            const unscaledViewport = page.getViewport({ scale: 1.0 });
            scale = containerWidth / unscaledViewport.width;
            queueRenderPage(pageNum);
        });
    });

    document.getElementById('fullscreen-toggle').addEventListener('click', function () {
        const elem = document.getElementById('reader-container');
        if (!document.fullscreenElement) {
            elem.requestFullscreen().catch(err => alert(`Error attempting to enable fullscreen: ${err.message}`));
        } else {
            document.exitFullscreen();
        }
    });

    // 3. Security Protections: Disable Right Click & Keyboard Print/Save Shortcuts
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        return false;
    });

    document.addEventListener('keydown', function (e) {
        // Block Ctrl+P, Ctrl+S, Ctrl+U, Cmd+P, Cmd+S
        if ((e.ctrlKey || e.metaKey) && ['p', 'P', 's', 'S', 'u', 'U'].includes(e.key)) {
            e.preventDefault();
            return false;
        }
        // Block F12 (DevTools)
        if (e.key === 'F12') {
            e.preventDefault();
            return false;
        }
        // Keyboard Arrow Navigation
        if (e.key === 'ArrowRight' || e.key === 'PageDown') {
            onNextPage();
        } else if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
            onPrevPage();
        }
    });
});
</script>
@endsection
