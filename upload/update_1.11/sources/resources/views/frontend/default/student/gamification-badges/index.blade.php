@extends('layouts.default')
@push('title', get_phrase('Badges'))
@push('meta')@endpush
<style>
    .badge-card{
    background:#fff;
    border-radius:12px;
    padding:25px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    transition:all .3s ease;
    height:100%;
}

.badge-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.badge-image{
    width:90px;
    height:90px;
    margin:0 auto 15px;
}

.badge-image img{
    width:100%;
    height:100%;
    object-fit:contain;
}

.badge-title {
	font-size: 16px;
	font-family: "Euclid Circular A";
	font-weight: 600;
	color: var(--color-2);
	margin-bottom: 5px;
}

</style>
@push('css')@endpush
@section('content')
    <section class="wishlist-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')



                <div class="col-lg-9">
                    <h4 class="g-title">{{ get_phrase('Badges') }}</h4>

                       <div class="row bg-white radius-10 mt-5 p-3">

    @if(!empty($all_badges))
        @foreach($all_badges as $badge)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="badge-card">
                    <div class="badge-image">
                        <img src="{{ asset('uploads/badges/'.$badge->image) }}" alt="{{ $badge->title }}">
                    </div>
                    <h3 class="badge-title">{{ $badge->title }}</h3>
                    <p>{{ $badge->description }}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-md-12 text-center py-5">
            @include('frontend.default.empty')
        </div>
    @endif

</div>

                </div>
            </div>
        </div>

        </div>
    </section>
    <!------------ My wishlist area End  ------------>
@endsection
@push('js')

@endpush
