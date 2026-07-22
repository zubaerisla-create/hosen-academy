@extends('layouts.default')

@section('content')
<section class="software-shop-page-wrapper">
    <!-- 1. HERO SECTION -->
    <div class="software-hero-section section-padding position-relative overflow-hidden">
        <div class="hero-bg-glow"></div>
        <div class="container position-relative z-index-2">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-badge-wrap mb-3">
                        <span class="software-badge">
                            <i class="fa-solid fa-handshake-simple me-2 text-indigo"></i>{{ get_phrase('Hosen Academy × Hosen Software Shop') }}
                        </span>
                    </div>
                    <h1 class="software-hero-title mb-4">
                        {{ get_phrase('Enterprise Digital Solutions & Custom Software Products') }}
                    </h1>
                    <p class="software-hero-desc mb-4">
                        {{ get_phrase('Hosen Academy & Hosen Software Shop work together to bridge education and real-world technology. We design, engineer, and deploy high-performance web applications, mobile apps, and business management systems tailored for your growth.') }}
                    </p>
                    <div class="hero-action-btns d-flex flex-wrap gap-3 align-items-center mb-4">
                        <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-shop-primary">
                            <span>{{ get_phrase('Visit Hosen Software Shop') }}</span>
                            <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                        </a>
                        <a href="https://wa.me/8801334958490" target="_blank" class="btn btn-shop-outline">
                            <i class="fa-brands fa-whatsapp text-success me-2 fs-5"></i>
                            <span>{{ get_phrase('Free Tech Consultation') }}</span>
                        </a>
                    </div>
                    <div class="hero-trust-metrics pt-3 d-flex align-items-center gap-4">
                        <div class="metric-item">
                            <h4 class="metric-num">50+</h4>
                            <span class="metric-label">{{ get_phrase('Custom Projects') }}</span>
                        </div>
                        <div class="metric-divider"></div>
                        <div class="metric-item">
                            <h4 class="metric-num">99.9%</h4>
                            <span class="metric-label">{{ get_phrase('Client Satisfaction') }}</span>
                        </div>
                        <div class="metric-divider"></div>
                        <div class="metric-item">
                            <h4 class="metric-num">24/7</h4>
                            <span class="metric-label">{{ get_phrase('Expert Support') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Meaningful 3D Studio Illustration Showcase -->
                <div class="col-lg-6">
                    <div class="hero-image-illustration-card position-relative shadow-2xl rounded-24 overflow-hidden border border-slate-700 bg-slate-900">
                        <div class="ide-header-bar px-4 py-3 bg-slate-950 border-bottom border-slate-800 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="dot red"></span>
                                <span class="dot yellow"></span>
                                <span class="dot green"></span>
                                <span class="ms-3 text-slate-300 fs-13 font-mono"><i class="fa-solid fa-store me-2 text-indigo"></i>hosen-software-shop.solutionsquad.tech</span>
                            </div>
                            <span class="badge bg-emerald-500-subtle text-emerald-400 rounded-pill px-3 py-1 fs-12 fw-bold"><i class="fa-solid fa-circle text-emerald-400 me-1"></i>Live Studio</span>
                        </div>
                        <div class="hero-img-box position-relative overflow-hidden">
                            <img src="{{ asset('assets/frontend/default/image/software_hero_illustration.jpg') }}" alt="Hosen Software Shop Studio" class="img-fluid w-100 hero-3d-img">
                            <div class="hero-img-overlay p-4 d-flex flex-column justify-content-end">
                                <div class="d-flex align-items-center justify-content-between bg-slate-900-80 backdrop-blur p-3 rounded-16 border border-slate-700">
                                    <div>
                                        <h5 class="fw-bold text-white mb-0">Hosen Software Shop</h5>
                                        <span class="fs-12 text-slate-300">Enterprise Digital Solutions Studio</span>
                                    </div>
                                    <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-shop-primary py-2 px-4 fs-13 rounded-pill fw-bold">
                                        <span>Visit Shop</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. FULL-WIDTH SYNERGY & COLLABORATION SHOWCASE -->
    <div class="collaboration-section section-padding bg-white border-top border-bottom">
        <div class="container">
            <!-- Header -->
            <div class="text-center max-w-4xl mx-auto mb-5">
                <span class="feature-section-badge mb-3">
                    <i class="fa-solid fa-handshake me-2"></i>{{ get_phrase('SYNERGY OF EDUCATION & ENTERPRISE ENGINEERING') }}
                </span>
                <h2 class="display-6 fw-extrabold text-slate-900 mb-3">{{ get_phrase('Where Learning Meets Real-World Enterprise Software Engineering') }}</h2>
                <p class="fs-16 text-slate-600 mb-0">
                    {{ get_phrase('Hosen Academy and Hosen Software Shop operate together as an integrated ecosystem—from empowering developers with cutting-edge skills to building commercial production-grade digital solutions for businesses worldwide.') }}
                </p>
            </div>

            <!-- 3-Step Synergy Ecosystem Flow (Full-Width 3-Column Layout) -->
            <div class="row g-4 mb-5">
                <!-- Step 1 -->
                <div class="col-lg-4">
                    <div class="synergy-flow-card h-100 p-4 rounded-24 bg-slate-50 border transition-all">
                        <div class="synergy-icon-wrap bg-indigo-subtle text-indigo mb-4">
                            <i class="fa-solid fa-graduation-cap fs-2"></i>
                        </div>
                        <span class="step-tag">STEP 01</span>
                        <h4 class="fw-bold text-slate-900 mt-2 mb-2">Hosen Academy</h4>
                        <span class="badge bg-indigo-100 text-indigo rounded-pill px-3 py-1 fs-12 mb-3">Skill & Training Engine</span>
                        <p class="fs-14 text-slate-600 mb-4">
                            Empowering students, developers, and tech enthusiasts through structured courses, eBooks, and hands-on skill development.
                        </p>
                        <div class="synergy-bullets fs-13 text-slate-700">
                            <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-circle-check text-success"></i> Comprehensive IT & Programming Courses</div>
                            <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-circle-check text-success"></i> Hands-on Project-based Learning</div>
                            <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-check text-success"></i> Professional Skill Certification</div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-4">
                    <div class="synergy-flow-card h-100 p-4 rounded-24 bg-slate-50 border transition-all highlight-card">
                        <div class="synergy-icon-wrap bg-emerald-subtle text-emerald mb-4">
                            <i class="fa-solid fa-code-merge fs-2"></i>
                        </div>
                        <span class="step-tag">STEP 02</span>
                        <h4 class="fw-bold text-slate-900 mt-2 mb-2">Synergy Hub</h4>
                        <span class="badge bg-emerald-100 text-emerald rounded-pill px-3 py-1 fs-12 mb-3">Engineering Production</span>
                        <p class="fs-14 text-slate-600 mb-4">
                            Bridging academic knowledge and commercial production. Transforming complex tech concepts into stable commercial software.
                        </p>
                        <div class="synergy-bullets fs-13 text-slate-700">
                            <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-circle-check text-success"></i> Production-Grade Source Code</div>
                            <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-circle-check text-success"></i> Enterprise Architecture (Laravel/Flutter)</div>
                            <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-check text-success"></i> Rigorous Quality Assurance</div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-4">
                    <div class="synergy-flow-card h-100 p-4 rounded-24 bg-slate-50 border transition-all">
                        <div class="synergy-icon-wrap bg-purple-subtle text-purple mb-4">
                            <i class="fa-solid fa-store fs-2"></i>
                        </div>
                        <span class="step-tag">STEP 03</span>
                        <h4 class="fw-bold text-slate-900 mt-2 mb-2">Hosen Software Shop</h4>
                        <span class="badge bg-purple-100 text-purple rounded-pill px-3 py-1 fs-12 mb-3">Digital Storefront & Studio</span>
                        <p class="fs-14 text-slate-600 mb-4">
                            Delivering custom web development, mobile apps, ready-made ERPs, LMS systems, and IT services to commercial clients globally.
                        </p>
                        <div class="synergy-bullets fs-13 text-slate-700">
                            <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-circle-check text-success"></i> 100% Owned Commercial Licenses</div>
                            <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-circle-check text-success"></i> Custom ERP, CRM & Mobile Apps</div>
                            <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-check text-success"></i> 24/7 Dedicated Server Maintenance</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4 Core Pillars Grid (Full Width 4 Columns) -->
            <div class="row g-4 pt-3">
                <div class="col-lg-3 col-md-6">
                    <div class="pillar-feature-item p-4 rounded-20 bg-white border h-100 shadow-sm">
                        <div class="pillar-badge-icon bg-indigo-50 text-indigo mb-3"><i class="fa-solid fa-layer-group fs-4"></i></div>
                        <h6 class="fw-bold text-slate-900 mb-2">Modern Tech Stack</h6>
                        <p class="fs-13 text-slate-600 mb-0">Built with PHP Laravel, Flutter, React, Vue, Python, and scalable Cloud API architecture.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="pillar-feature-item p-4 rounded-20 bg-white border h-100 shadow-sm">
                        <div class="pillar-badge-icon bg-emerald-50 text-emerald mb-3"><i class="fa-solid fa-file-code fs-4"></i></div>
                        <h6 class="fw-bold text-slate-900 mb-2">Full Source Code</h6>
                        <p class="fs-13 text-slate-600 mb-0">Complete source code ownership, clean documentation, and transparent commercial licensing.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="pillar-feature-item p-4 rounded-20 bg-white border h-100 shadow-sm">
                        <div class="pillar-badge-icon bg-amber-50 text-amber mb-3"><i class="fa-solid fa-bolt fs-4"></i></div>
                        <h6 class="fw-bold text-slate-900 mb-2">Instant Deployment</h6>
                        <p class="fs-13 text-slate-600 mb-0">Turnkey web scripts, payment gateway sync, and fast installation support.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="pillar-feature-item p-4 rounded-20 bg-white border h-100 shadow-sm">
                        <div class="pillar-badge-icon bg-purple-50 text-purple mb-3"><i class="fa-solid fa-headset fs-4"></i></div>
                        <h6 class="fw-bold text-slate-900 mb-2">Continuous Support</h6>
                        <p class="fs-13 text-slate-600 mb-0">Dedicated maintenance, security audits, feature updates, and expert consultations.</p>
                    </div>
                </div>
            </div>

            <!-- Prominent Direct Visit Link CTA -->
            <div class="text-center mt-5 pt-3">
                <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-shop-primary btn-lg px-5 py-3 rounded-pill shadow-lg">
                    <span>Explore Hosen Software Shop Products</span>
                    <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- 3. OVERVIEW OF SERVICES OFFERED -->
    <div class="services-overview-section section-padding bg-slate-50">
        <div class="container">
            <div class="text-center max-w-3xl mx-auto mb-5">
                <span class="feature-section-badge">
                    <i class="fa-solid fa-layer-group me-2"></i>{{ get_phrase('CORE CAPABILITIES') }}
                </span>
                <h2 class="section-title mt-2">{{ get_phrase('Services & Solutions Offered') }}</h2>
                <p class="section-desc">{{ get_phrase('From custom web & mobile apps to turnkey business ERPs, we provide comprehensive software engineering.') }}</p>
            </div>

            <div class="row g-4">
                @foreach ($services as $s_slug => $s_item)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('software.service.details', ['slug' => $s_slug]) }}" class="text-decoration-none">
                            <div class="software-service-card h-100">
                                <div class="service-icon-box {{ $s_item['bg_class'] }} {{ $s_item['text_class'] }} mb-3">
                                    <i class="{{ $s_item['icon'] }} fs-4"></i>
                                </div>
                                <h5 class="service-title">{{ $s_item['title'] }}</h5>
                                <p class="service-desc mb-3">{{ $s_item['summary'] }}</p>
                                <span class="service-link-btn text-indigo fw-bold fs-13 d-inline-flex align-items-center">
                                    {{ get_phrase('View Details & Features') }}
                                    <i class="fa-solid fa-arrow-right ms-1 transition-icon"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 4. SAMPLE PRODUCT SHOWCASE -->
    <div class="product-showcase-section section-padding bg-white">
        <div class="container">
            <div class="text-center max-w-3xl mx-auto mb-5">
                <span class="feature-section-badge">
                    <i class="fa-solid fa-store me-2"></i>{{ get_phrase('FEATURED SOFTWARE PRODUCTS') }}
                </span>
                <h2 class="section-title mt-2">{{ get_phrase('Explore Our Signature Software Suite') }}</h2>
                <p class="section-desc">{{ get_phrase('Discover sample software products available for immediate deployment and customization.') }}</p>
            </div>

            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item-card h-100 border rounded-24 overflow-hidden shadow-sm">
                        <div class="product-card-banner bg-indigo-dark p-4 text-white position-relative">
                            <span class="badge bg-indigo-accent position-absolute top-3 right-3">Enterprise LMS</span>
                            <i class="fa-solid fa-graduation-cap display-4 opacity-50"></i>
                            <h4 class="fw-bold mt-3 mb-1">Hosen LMS Suite</h4>
                            <span class="fs-12 opacity-75">v3.5 • Full PHP Laravel Source</span>
                        </div>
                        <div class="product-card-body p-4">
                            <ul class="product-spec-list mb-4">
                                <li><i class="fa-solid fa-check text-success me-2"></i>Multi-Instructor & Course Builder</li>
                                <li><i class="fa-solid fa-check text-success me-2"></i>bKash, SSLCommerz & Stripe Integrated</li>
                                <li><i class="fa-solid fa-check text-success me-2"></i>Live Class & Certificate Generator</li>
                            </ul>
                            <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-outline-indigo w-100 rounded-pill fw-bold">
                                View Product Details <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item-card h-100 border rounded-24 overflow-hidden shadow-sm">
                        <div class="product-card-banner bg-emerald-dark p-4 text-white position-relative">
                            <span class="badge bg-emerald-accent position-absolute top-3 right-3">Business ERP</span>
                            <i class="fa-solid fa-building-user display-4 opacity-50"></i>
                            <h4 class="fw-bold mt-3 mb-1">Academy ERP Pro</h4>
                            <span class="fs-12 opacity-75">v2.0 • Web + Mobile App</span>
                        </div>
                        <div class="product-card-body p-4">
                            <ul class="product-spec-list mb-4">
                                <li><i class="fa-solid fa-check text-success me-2"></i>Student & Fee Management</li>
                                <li><i class="fa-solid fa-check text-success me-2"></i>HRM, Payroll & Expense Tracker</li>
                                <li><i class="fa-solid fa-check text-success me-2"></i>Automated SMS & Email Alerts</li>
                            </ul>
                            <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-outline-emerald w-100 rounded-pill fw-bold">
                                View Product Details <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item-card h-100 border rounded-24 overflow-hidden shadow-sm">
                        <div class="product-card-banner bg-purple-dark p-4 text-white position-relative">
                            <span class="badge bg-purple-accent position-absolute top-3 right-3">Multi-Vendor E-com</span>
                            <i class="fa-solid fa-bag-shopping display-4 opacity-50"></i>
                            <h4 class="fw-bold mt-3 mb-1">E-Commerce Engine</h4>
                            <span class="fs-12 opacity-75">v4.0 • Flutter Android/iOS App</span>
                        </div>
                        <div class="product-card-body p-4">
                            <ul class="product-spec-list mb-4">
                                <li><i class="fa-solid fa-check text-success me-2"></i>Multi-Vendor Store & Commission</li>
                                <li><i class="fa-solid fa-check text-success me-2"></i>Real-time Order & Delivery Tracking</li>
                                <li><i class="fa-solid fa-check text-success me-2"></i>High-Speed Mobile App Suite</li>
                            </ul>
                            <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-outline-purple w-100 rounded-pill fw-bold">
                                View Product Details <i class="fa-solid fa-arrow-up-right-from-square ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prominent Button Box -->
            <div class="text-center mt-5 pt-3">
                <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-shop-primary btn-lg px-5 py-3 rounded-pill">
                    <span>Visit Hosen Software Shop Catalog</span>
                    <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- 5. PROMINENT CALL TO ACTION BANNER -->
    <div class="software-cta-section section-padding text-white">
        <div class="container">
            <div class="cta-gradient-box p-5 rounded-32 text-center position-relative overflow-hidden shadow-2xl">
                <div class="cta-bg-glow"></div>
                <div class="position-relative z-index-2 max-w-3xl mx-auto">
                    <span class="badge bg-white-20 text-white rounded-pill px-4 py-2 fw-bold text-uppercase mb-3">
                        <i class="fa-solid fa-rocket me-2"></i>Ready to Build Your Custom Software?
                    </span>
                    <h2 class="display-5 fw-extrabold mb-4 text-white">
                        Let's Turn Your Vision Into Enterprise Reality
                    </h2>
                    <p class="fs-16 opacity-90 mb-4">
                        Visit Hosen Software Shop to browse ready-made software products or schedule a free consultation with our senior engineering team.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3 align-items-center">
                        <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="btn btn-light-glow btn-lg px-5 py-3 rounded-pill fw-bold text-indigo">
                            Visit Hosen Software Shop
                            <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                        </a>
                        <a href="https://wa.me/8801334958490" target="_blank" class="btn btn-whatsapp-glow btn-lg px-4 py-3 rounded-pill fw-bold text-white">
                            <i class="fa-brands fa-whatsapp me-2 fs-5"></i>
                            WhatsApp Consultation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SOFTWARE SHOP PAGE CUSTOM STYLES -->
<style>
.software-shop-page-wrapper {
    background-color: #f8fafc;
}

/* Hero Section */
.software-hero-section {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
    color: #ffffff;
    padding: 90px 0;
}

.hero-bg-glow {
    position: absolute;
    top: -20%;
    right: -10%;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(0, 0, 0, 0) 70%);
    pointer-events: none;
}

.software-badge {
    background: rgba(255, 255, 255, 0.1);
    color: #a5b4fc;
    font-size: 13px;
    font-weight: 700;
    padding: 8px 18px;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.software-hero-title {
    font-size: 42px;
    font-weight: 800;
    line-height: 1.2;
    color: #ffffff;
}

.software-hero-desc {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.65;
}

.btn-shop-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: #ffffff !important;
    padding: 14px 28px;
    border-radius: 50px;
    font-weight: 700;
    box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
    transition: all 0.3s ease;
    border: none;
}

.btn-shop-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(79, 70, 229, 0.6);
}

.btn-shop-outline {
    background: rgba(255, 255, 255, 0.08);
    color: #ffffff !important;
    padding: 14px 28px;
    border-radius: 50px;
    font-weight: 700;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.btn-shop-outline:hover {
    background: rgba(255, 255, 255, 0.18);
    border-color: rgba(255, 255, 255, 0.4);
}

.metric-num {
    font-size: 24px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 2px;
}

.metric-label {
    font-size: 12px;
    color: #94a3b8;
}

.metric-divider {
    width: 1px;
    height: 35px;
    background: rgba(255, 255, 255, 0.15);
}

/* IDE Window Card */
.hero-ide-window {
    background: #090d16;
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6);
}

.dots-wrap .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}
.dots-wrap .red { background: #ef4444; }
.dots-wrap .yellow { background: #f59e0b; }
.dots-wrap .green { background: #10b981; }

.shop-logo-box {
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-indigo-glow-lg {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
    transition: all 0.3s ease;
}

.btn-indigo-glow-lg:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(79, 70, 229, 0.6);
}

/* Synergy Flow Card */
.synergy-flow-card {
    position: relative;
    box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.05);
}

.synergy-flow-card:hover {
    transform: translateY(-6px);
    border-color: #6366f1 !important;
    box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.15);
}

.synergy-flow-card.highlight-card {
    background: #ffffff !important;
    border: 2px solid #10b981 !important;
}

.step-tag {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    color: #94a3b8;
}

.synergy-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pillar-badge-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-indigo-subtle { background: rgba(79, 70, 229, 0.1); }
.bg-emerald-subtle { background: rgba(16, 185, 129, 0.1); }
.bg-purple-subtle { background: rgba(168, 85, 247, 0.1); }

.text-indigo { color: #4f46e5 !important; }
.text-emerald { color: #10b981 !important; }
.text-purple { color: #a855f7 !important; }

.rounded-24 { border-radius: 24px; }
.rounded-20 { border-radius: 20px; }
.rounded-16 { border-radius: 16px; }

/* Services Grid */
.software-service-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 24px;
    transition: all 0.3s ease;
}

.software-service-card:hover {
    transform: translateY(-5px);
    border-color: #6366f1;
    box-shadow: 0 15px 35px -10px rgba(99, 102, 241, 0.15);
}

.service-icon-box {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.service-title {
    font-size: 17px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 8px;
}

.service-desc {
    font-size: 13.5px;
    color: #64748b;
    margin-bottom: 0;
    line-height: 1.55;
}

/* Product Showcase */
.product-card-banner.bg-indigo-dark { background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); }
.product-card-banner.bg-emerald-dark { background: linear-gradient(135deg, #064e3b 0%, #047857 100%); }
.product-card-banner.bg-purple-dark { background: linear-gradient(135deg, #581c87 0%, #7e22ce 100%); }

.bg-indigo-accent { background: #6366f1; }
.bg-emerald-accent { background: #10b981; }
.bg-purple-accent { background: #a855f7; }

.product-spec-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
    font-size: 13.5px;
    color: #334155;
}

.btn-outline-indigo { border: 1px solid #4f46e5; color: #4f46e5; }
.btn-outline-indigo:hover { background: #4f46e5; color: #ffffff; }

.btn-outline-emerald { border: 1px solid #10b981; color: #10b981; }
.btn-outline-emerald:hover { background: #10b981; color: #ffffff; }

.btn-outline-purple { border: 1px solid #a855f7; color: #a855f7; }
.btn-outline-purple:hover { background: #a855f7; color: #ffffff; }

/* CTA Section */
.cta-gradient-box {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 32px;
}

.cta-bg-glow {
    position: absolute;
    top: -50%;
    left: -20%;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
}

.btn-light-glow {
    background: #ffffff;
    color: #4f46e5 !important;
    box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.btn-light-glow:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(255, 255, 255, 0.5);
}

.btn-whatsapp-glow {
    background: #25D366;
    color: #ffffff !important;
    box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4);
}

.btn-whatsapp-glow:hover {
    background: #128C7E;
    transform: translateY(-2px);
}

/* Hero 3D Illustration Overlay Styles */
.hero-image-illustration-card {
    box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.hero-image-illustration-card:hover {
    transform: translateY(-6px);
}

.hero-3d-img {
    object-fit: cover;
    max-height: 420px;
    transition: transform 0.6s ease;
}

.hero-image-illustration-card:hover .hero-3d-img {
    transform: scale(1.04);
}

.hero-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 23, 42, 0) 40%, rgba(15, 23, 42, 0.95) 100%);
}

.backdrop-blur {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.bg-slate-900-80 {
    background: rgba(15, 23, 42, 0.85);
}

@media (min-width: 992px) {
    .software-hero-section .row {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
    }

    .software-hero-section .col-lg-6 {
        flex: 0 0 48.5% !important;
        max-width: 48.5% !important;
        width: 48.5% !important;
    }
}
</style>
@endsection
