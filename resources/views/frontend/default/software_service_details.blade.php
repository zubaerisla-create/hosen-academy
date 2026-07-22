@extends('layouts.default')

@section('content')
<section class="service-details-page-wrapper">

    <!-- HERO BREADCRUMB HEADER -->
    <div class="service-hero-header py-5 bg-slate-900 text-white position-relative overflow-hidden">
        <div class="hero-bg-glow"></div>
        <div class="container position-relative z-index-2">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: #94a3b8 !important;"><i class="fa-solid fa-house me-1"></i>{{ get_phrase('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('software.shop') }}" class="text-decoration-none" style="color: #94a3b8 !important;">{{ get_phrase('Software Shop') }}</a></li>
                    <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: #38bdf8 !important;">{{ $service['title'] }}</li>
                </ol>
            </nav>

            <div class="row align-items-center g-4">
                <div class="col-lg-9 col-xl-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="service-detail-icon-badge p-3 rounded-16" style="background: rgba(255, 255, 255, 0.15) !important; color: #ffffff !important; border: 1px solid rgba(255, 255, 255, 0.25) !important;">
                            <i class="{{ $service['icon'] }} fs-2" style="color: #ffffff !important;"></i>
                        </div>
                        <span class="badge rounded-pill px-3 py-2 fs-13 fw-bold" style="background: rgba(99, 102, 241, 0.25) !important; color: #a5b4fc !important; border: 1px solid rgba(99, 102, 241, 0.4) !important;">Enterprise Service</span>
                    </div>
                    <h1 class="display-5 fw-extrabold mb-3 text-white" style="color: #ffffff !important;">{{ $service['title'] }}</h1>
                    <p class="fs-18 mb-4 max-w-3xl leading-relaxed" style="color: #cbd5e1 !important;">{{ $service['tagline'] }}</p>
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <a href="https://wa.me/8801334958490?text=Hello!%20I%20am%20interested%20in%20your%20{{ urlencode($service['title']) }}%20service." target="_blank" class="btn btn-whatsapp-solid px-4 py-3 rounded-pill fw-bold text-white fs-14">
                            <i class="fa-brands fa-whatsapp me-2 fs-5"></i>{{ get_phrase('Consult on WhatsApp') }}
                        </a>
                        <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-shop-outline px-4 py-3 rounded-pill fw-bold text-white fs-14">
                            <span>{{ get_phrase('Visit Hosen Software Shop') }}</span>
                            <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN SERVICE CONTENT & SIDEBAR (Full Widescreen Container) -->
    <div class="service-content-body section-padding bg-slate-50">
        <div class="container-fluid px-3 px-md-4 px-lg-5 max-w-1440">
            <div class="row g-4 g-xl-5">

                <!-- LEFT MAIN COLUMN (Spans 67% on widescreen) -->
                <div class="col-xl-8 col-lg-7 col-md-12">

                    <!-- 1. Overview Card -->
                    <div class="detail-card p-4 p-md-5 rounded-24 bg-white border shadow-sm mb-4 mb-md-5">
                        <span class="feature-section-badge mb-3"><i class="fa-solid fa-circle-info me-2"></i>{{ get_phrase('SERVICE OVERVIEW') }}</span>
                        <h3 class="fw-bold text-slate-900 mb-3">{{ get_phrase('Comprehensive Solutions & Strategic Value') }}</h3>
                        <p class="fs-16 text-slate-600 leading-relaxed mb-0">{{ $service['description'] }}</p>
                    </div>

                    <!-- 2. Technical Features Grid -->
                    <div class="detail-card p-4 p-md-5 rounded-24 bg-white border shadow-sm mb-4 mb-md-5">
                        <span class="feature-section-badge mb-3"><i class="fa-solid fa-microchip me-2"></i>{{ get_phrase('KEY CAPABILITIES') }}</span>
                        <h3 class="fw-bold text-slate-900 mb-4">{{ get_phrase('Technical Capabilities & Features') }}</h3>

                        <div class="row g-4">
                            @foreach ($service['features'] as $feature)
                                <div class="col-sm-6">
                                    <div class="feature-capability-box p-4 rounded-20 bg-slate-50 border h-100">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="fa-solid fa-circle-check text-emerald fs-5"></i>
                                            <h5 class="fw-bold text-slate-900 mb-0 fs-16">{{ $feature['title'] }}</h5>
                                        </div>
                                        <p class="fs-13 text-slate-600 mb-0 leading-relaxed">{{ $feature['desc'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 3. Technologies Used Stack Pills -->
                    <div class="detail-card p-4 p-md-5 rounded-24 bg-white border shadow-sm mb-4 mb-md-5">
                        <span class="feature-section-badge mb-3"><i class="fa-solid fa-code me-2"></i>{{ get_phrase('TECHNOLOGY STACK') }}</span>
                        <h3 class="fw-bold text-slate-900 mb-3">{{ get_phrase('Technologies & Frameworks Utilized') }}</h3>
                        <p class="fs-14 text-slate-600 mb-4">{{ get_phrase('We leverage modern, industry-standard frameworks and cloud infrastructure for security and scalability.') }}</p>

                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($service['tech_stack'] as $tech)
                                <span class="tech-pill-badge px-3 py-2 rounded-12 bg-indigo-subtle text-indigo font-mono fw-semibold fs-13 border border-indigo-200">
                                    <i class="fa-solid fa-cube me-1"></i>{{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- 4. Workflow Timeline -->
                    <div class="detail-card p-4 p-md-5 rounded-24 bg-white border shadow-sm mb-4 mb-md-5">
                        <span class="feature-section-badge mb-3"><i class="fa-solid fa-list-check me-2"></i>{{ get_phrase('DEVELOPMENT PROCESS') }}</span>
                        <h3 class="fw-bold text-slate-900 mb-4">{{ get_phrase('Step-by-Step Workflow & Execution') }}</h3>

                        <div class="workflow-timeline-wrapper">
                            @foreach ($service['workflow'] as $step => $step_info)
                                <div class="timeline-step-item d-flex gap-3 gap-md-4 mb-4">
                                    <div class="step-num-badge bg-indigo text-white rounded-16 fw-extrabold flex-shrink-0 d-flex align-items-center justify-content-center">
                                        {{ $step }}
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-slate-900 mb-1">{{ $step_info['title'] }}</h5>
                                        <p class="fs-14 text-slate-600 mb-0 leading-relaxed">{{ $step_info['desc'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- 5. CTA Box (High-Contrast Text & Solid Buttons) -->
                    <div class="detail-cta-box p-4 p-md-5 rounded-24 text-white shadow-xl position-relative overflow-hidden mb-4">
                        <div class="position-relative z-index-2">
                            <h3 class="fw-extrabold text-white mb-2 fs-24" style="color: #ffffff !important;">Ready to Start Your Project?</h3>
                            <p class="fs-15 mb-4 max-w-2xl leading-relaxed" style="color: rgba(255, 255, 255, 0.95) !important;">Connect with senior engineers at Hosen Software Shop for a free technical estimate and architecture consultation.</p>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <a href="https://wa.me/8801334958490?text=Hello!%20I%20want%20to%20discuss%20a%20project%20regarding%20{{ urlencode($service['title']) }}." target="_blank" class="btn btn-whatsapp-solid px-4 py-3 rounded-pill fw-bold text-white fs-14">
                                    <i class="fa-brands fa-whatsapp me-2 fs-5"></i>WhatsApp: 01334958490
                                </a>
                                <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-white-solid px-4 py-3 rounded-pill fw-bold text-indigo fs-14">
                                    <span>Visit Hosen Software Shop</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDEBAR (Spans 33% on widescreen) -->
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <div class="sticky-sidebar-wrapper">

                        <!-- Quick Contact Card -->
                        <div class="sidebar-card p-4 rounded-24 bg-white border shadow-sm mb-4">
                            <h5 class="fw-bold text-slate-900 mb-3"><i class="fa-solid fa-headset text-indigo me-2"></i>{{ get_phrase('Project Consultation') }}</h5>
                            <p class="fs-13 text-slate-600 mb-4">{{ get_phrase('Talk to our lead engineer for custom quotes and project timelines.') }}</p>

                            <div class="d-flex flex-column gap-3 mb-4">
                                <a href="https://wa.me/8801334958490" target="_blank" class="btn btn-whatsapp-solid py-3 rounded-16 fw-bold w-100 text-center">
                                    <i class="fa-brands fa-whatsapp me-2 fs-5"></i>WhatsApp Chat
                                </a>
                                <a href="tel:01334958490" class="btn btn-outline-dark py-3 rounded-16 fw-bold w-100 text-center">
                                    <i class="fa-solid fa-phone me-2"></i>Call: 01334958490
                                </a>
                            </div>
                            <span class="fs-12 text-slate-400 d-block text-center"><i class="fa-solid fa-shield-halved me-1 text-success"></i>100% Confidential & Free Consultation</span>
                        </div>

                        <!-- All Services Navigation List -->
                        <div class="sidebar-card p-4 rounded-24 bg-white border shadow-sm mb-4">
                            <h5 class="fw-bold text-slate-900 mb-3"><i class="fa-solid fa-layer-group text-indigo me-2"></i>{{ get_phrase('All Software Services') }}</h5>

                            <div class="sidebar-services-list d-flex flex-column gap-2">
                                @foreach ($all_services as $s_slug => $s_item)
                                    <a href="{{ route('software.service.details', ['slug' => $s_slug]) }}" class="sidebar-service-item p-3 rounded-16 border d-flex align-items-center justify-content-between text-decoration-none @if($s_slug == $service['slug']) active-service @endif">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="{{ $s_item['icon'] }} {{ $s_item['text_class'] }}"></i>
                                            <span class="fs-14 fw-semibold text-slate-800">{{ $s_item['title'] }}</span>
                                        </div>
                                        <i class="fa-solid fa-chevron-right fs-12 text-slate-400"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Official Store External Link Banner (High-Contrast Explicit Dark Card) -->
                        <div class="sidebar-store-banner-card p-4 rounded-24 text-white shadow-xl text-center mb-4">
                            <div class="banner-icon-circle mx-auto mb-3">
                                <i class="fa-solid fa-cubes-stacked text-indigo fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-white mb-2 fs-18" style="color: #ffffff !important;">Hosen Software Shop</h5>
                            <p class="fs-13 mb-4 leading-relaxed" style="color: #cbd5e1 !important;">Visit our official store to view ready-made software scripts, custom ERPs & downloadable code.</p>
                            <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-shop-primary w-100 py-3 rounded-16 fw-bold text-white">
                                <span>Visit Official Store</span>
                                <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- SERVICE DETAILS CUSTOM STYLES -->
<style>
.max-w-1440 {
    max-width: 1440px !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

.service-details-page-wrapper {
    background-color: #f8fafc;
}

.service-hero-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
}

.service-hero-header .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6) !important;
}

.service-hero-header .breadcrumb-item a:hover {
    color: #ffffff !important;
}

.service-hero-header .breadcrumb-item.active {
    color: #38bdf8 !important;
    font-weight: 700 !important;
}

.service-detail-icon-badge {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-capability-box {
    transition: transform 0.2s ease, border-color 0.2s ease;
}

.feature-capability-box:hover {
    transform: translateY(-3px);
    border-color: #6366f1 !important;
}

.tech-pill-badge {
    transition: transform 0.2s ease;
}

.tech-pill-badge:hover {
    transform: translateY(-2px);
}

.step-num-badge {
    width: 46px;
    height: 46px;
    font-size: 18px;
}

.bg-indigo { background: #4f46e5 !important; }

/* Left CTA Box */
.detail-cta-box {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
}

.btn-whatsapp-solid {
    background: #25D366 !important;
    color: #ffffff !important;
    border: none !important;
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4) !important;
    transition: all 0.2s ease !important;
}

.btn-whatsapp-solid:hover {
    background: #128C7E !important;
    transform: translateY(-2px) !important;
    color: #ffffff !important;
}

.btn-white-solid {
    background: #ffffff !important;
    color: #4f46e5 !important;
    border: none !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    transition: all 0.2s ease !important;
}

.btn-white-solid:hover {
    background: #f8fafc !important;
    color: #3730a3 !important;
    transform: translateY(-2px) !important;
}

/* Sidebar Store Banner */
.sidebar-store-banner-card {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%) !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
}

.banner-icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(79, 70, 229, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(79, 70, 229, 0.4);
}

.sidebar-service-item {
    background: #ffffff;
    transition: all 0.2s ease;
}

.sidebar-service-item:hover,
.sidebar-service-item.active-service {
    background: #eef2ff !important;
    border-color: #6366f1 !important;
}

.sidebar-service-item.active-service span {
    color: #4f46e5 !important;
    font-weight: 700 !important;
}

.sticky-sidebar-wrapper {
    position: sticky;
    top: 100px;
}

.rounded-24 { border-radius: 24px; }
.rounded-20 { border-radius: 20px; }
.rounded-16 { border-radius: 16px; }
.rounded-12 { border-radius: 12px; }

/* Responsive Grid Rules for Widescreen & Mobile */
@media (min-width: 992px) {
    .service-content-body .row {
        display: flex !important;
        flex-direction: row !important;
        justify-content: space-between !important;
    }
}

@media (max-width: 991px) {
    .sticky-sidebar-wrapper {
        position: static !important;
        margin-top: 30px;
    }
}

@media (max-width: 576px) {
    .service-hero-header {
        padding: 40px 0 !important;
    }
    .service-hero-header h1 {
        font-size: 26px !important;
    }
    .detail-card {
        padding: 20px !important;
        border-radius: 16px !important;
    }
    .btn-whatsapp-solid,
    .btn-white-solid,
    .btn-shop-outline {
        width: 100% !important;
        justify-content: center !important;
    }
}
</style>
@endsection
