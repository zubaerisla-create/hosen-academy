{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<section class="performance-wrapper section-padding">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-5">
            <span class="feature-section-badge">
                <i class="fa-solid fa-sparkles me-2"></i>{{ get_phrase('কেন হোসেন একাডেমি সেরা') }}
            </span>
            <h2 class="feature-section-title mt-2">{{ get_phrase('আমাদের বিশেষত্ব ও সেবাসমূহ') }}</h2>
            <p class="feature-section-desc">{{ get_phrase('অভিজ্ঞ শিক্ষক, উন্নত পাঠ্যক্রম এবং সার্বক্ষণিক সাপোর্টের মাধ্যমে আমরা দিচ্ছি বিশ্বমানের শিখন অভিজ্ঞতা।') }}</p>
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
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('অভিজ্ঞ ও পেশাদার শিক্ষক দ্বারা সহজ পাঠদান') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('জটিল বিষয় বুঝিয়ে সহানুভূতির সাথে উত্তর') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('নিয়মিত আপডেট ও দ্রুত সাপোর্ট সুবিধা') }}</li>
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
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('শেখার নির্ভরযোগ্য সাথি শিক্ষক ও সাপোর্ট টিম') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('ভর্তি থেকে সনদ – সব কাজে সার্বক্ষণিক পাশে') }}</li>
                        <li><i class="fa-solid fa-phone text-primary me-2"></i>{{ get_phrase('জানতে কল করুন: 01334958490') }}</li>
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
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('ক্লাসে প্রশ্ন করলে সঙ্গে সঙ্গেই উত্তর পাওয়া যায়') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('পেমেন্ট ও এক্সেস সমস্যার তাৎক্ষণিক সমাধান') }}</li>
                        <li><i class="fa-brands fa-whatsapp text-success me-2"></i>{{ get_phrase('ফোন, মেসেঞ্জার ও হোয়াটসঅ্যাপে যোগাযোগ') }}</li>
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
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('সহজেই শিখুন, সফল হোন সহজ কোর্সে') }}</li>
                        <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ get_phrase('সিলেবাস অনুযায়ী HD ভিডিও ক্লাস ও PDF') }}</li>
                        <li><i class="fa-solid fa-phone text-primary me-2"></i>{{ get_phrase('ভর্তি নিতে কল করুন: 01334958490') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
