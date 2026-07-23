{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- "builder identity" and "builder editable" --}}
{{-- builder identity value have to be unique under a single file --}}

<section>
    <div class="container">
        <div class="row g-28px align-items-center mb-100px">
            <div class="col-xl-5 col-lg-6">
                <div class="community-banner-2">
                    @php
                        $storImage = json_decode(get_homepage_settings('university'));
                    @endphp
                    @if (isset($storImage->faq_image))
                        <img src="{{ asset('uploads/home_page_image/university/' . $storImage->image) }}" alt="">
                    @endif
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">
                <div class="ms-xl-3 drop-area">
                    <h2 class="title-5 fs-32px lh-42px fw-500 mb-30px builder-editable" builder-identity="1">{{ get_phrase('শেখাকে আনন্দময় যাত্রায় পরিণত করা আমাদের লক্ষ্য।') }}</h2>
                    <p class="subtitle-5 fs-15px lh-25px mb-30px builder-editable" builder-identity="2">{{ get_phrase('হোসেন একাডেমি শুধু কোর্সের প্ল্যাটফর্ম নয়—এটি এমন এক শেখার কমিউনিটি যেখানে কৌতূহল জাগে, প্রশ্নের মূল্য দেওয়া হয়, আর জ্ঞান ভাগাভাগি হয়ে ওঠে সবার শক্তি। এখানে আপনি যেকোনো প্রশ্ন করতে পারবেন, নিজের অভিজ্ঞতা শেয়ার করতে পারবেন, এবং বিশেষজ্ঞ ও সহশিক্ষার্থীদের কাছ থেকে পাবেন সহায়ক পরামর্শ। বিভিন্ন দৃষ্টিভঙ্গি ও অভিজ্ঞতার এই কমিউনিটি আপনার চিন্তা প্রসারিত করবে এবং শেখাকে আরও আনন্দদায়ক করবে। ') }}</p>
                    <p class="subtitle-5 fs-15px lh-25px mb-30px builder-editable" builder-identity="3">{{ get_phrase('হোসেন একাডেমিতে আপনি নিজের অভিজ্ঞতা ও চ্যালেঞ্জ শেয়ার করতে পারবেন এবং একই পথে থাকা অন্যদের থেকে পাবেন অনুপ্রেরণা ও উৎসাহ।
আমাদের কমিউনিটির বৈচিত্র্যময় দৃষ্টিভঙ্গি আপনার চিন্তাকে প্রসারিত করবে এবং নতুনভাবে ভাবতে সাহায্য করবে।
এখানে একে অপরের অভিজ্ঞতা থেকে শেখা শেখাকে আরও গভীর ও অর্থবহ করে তোলে।
একাকী শেখার পরিবর্তে আমরা শেখাকে একটি যৌথ অভিযানে রূপান্তর করতে চাই।
জ্ঞান ভাগাভাগির এই সহযোগিতাই ব্যক্তিগত উন্নতি ও সমষ্টিগত অগ্রগতিকে ত্বরান্বিত করে।') }}</p>
                    <a href="{{ route('about.us') }}" class="btn btn-danger-1 builder-editable" builder-identity="4">{{ get_phrase('Learn more about us') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
