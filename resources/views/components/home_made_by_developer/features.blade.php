{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<section class="performance-wrapper section-padding">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-5">
            <span class="feature-section-badge">
                <i class="fa-solid fa-sparkles me-2"></i>{{ get_phrase('WHY CHOOSE US') }}
            </span>
            <h2 class="feature-section-title mt-2">{{ get_phrase('Key Features & Excellence') }}</h2>
            <p class="feature-section-desc">{{ get_phrase('Empowering students and creators with high-performance learning, dedicated support, and career-oriented curriculum.') }}</p>
        </div>

        <!-- Features Grid -->
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="premium-feature-card h-100 drop-area">
                    <div class="feature-card-top">
                        <div class="feature-icon-wrapper icon-indigo">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <span class="feature-card-num">01</span>
                    </div>
                    <h4 class="builder-editable feature-title" builder-identity="2">{{ get_phrase('Fast Performance') }}</h4>
                    <ul class="feature-list builder-editable" builder-identity="3">
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Expert and professional instructors') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Real-world practical learning flow') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Regular course updates & rapid support') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="premium-feature-card h-100 drop-area">
                    <div class="feature-card-top">
                        <div class="feature-icon-wrapper icon-emerald">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <span class="feature-card-num">02</span>
                    </div>
                    <h4 class="builder-editable feature-title" builder-identity="5">{{ get_phrase('Perfect Responsive') }}</h4>
                    <ul class="feature-list builder-editable" builder-identity="6">
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Dedicated support staff team') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Guidance from admission to certification') }}</li>
                        <li><i class="fa-solid fa-phone text-primary me-2"></i>{{ get_phrase('Call: 01334958490') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="premium-feature-card h-100 drop-area">
                    <div class="feature-card-top">
                        <div class="feature-icon-wrapper icon-amber">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <span class="feature-card-num">03</span>
                    </div>
                    <h4 class="builder-editable feature-title" builder-identity="8">{{ get_phrase('Fast & Friendly Support') }}</h4>
                    <ul class="feature-list builder-editable" builder-identity="9">
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Instant doubt clearing during classes') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Immediate payment & access assistance') }}</li>
                        <li><i class="fa-brands fa-whatsapp text-success me-2"></i>{{ get_phrase('Easy Phone & WhatsApp communication') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="premium-feature-card h-100 drop-area">
                    <div class="feature-card-top">
                        <div class="feature-icon-wrapper icon-purple">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <span class="feature-card-num">04</span>
                    </div>
                    <h4 class="builder-editable feature-title" builder-identity="11">{{ get_phrase('Easy to Use') }}</h4>
                    <ul class="feature-list builder-editable" builder-identity="12">
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Learn easily and succeed faster') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('Comprehensive video lessons & PDFs') }}</li>
                        <li><i class="fa-solid fa-phone text-primary me-2"></i>{{ get_phrase('Admission: 01334958490') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
