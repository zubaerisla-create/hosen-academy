@extends('layouts.default')
@push('title', get_phrase('Posts'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <style>
        .shared-post-wrapper {
            padding: 40px 0;
        }

        .shared-post-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, .05);
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .author-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-info h6 {
            margin-bottom: 3px;
            font-weight: 600;
        }

        .post-media {
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .post-media img,
        .post-media video {
            width: 100%;
            max-height: 650px;
            object-fit: cover;
            display: block;
        }

        .post-description {
            font-size: 15px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, .05);
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .popular-post-item {
            display: flex;
            gap: 12px;
            text-decoration: none;
            color: #212529;
            margin-bottom: 18px;
        }

        .popular-post-item:last-child {
            margin-bottom: 0;
        }

        .popular-post-item:hover {
            color: #0d6efd;
        }

        .popular-thumb {
            width: 120px;
            min-width: 120px;
            height: 80px;
            border-radius: 10px;
            overflow: hidden;
            background: #f5f5f5;
        }

        .popular-thumb img,
        .popular-thumb video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .popular-content h6 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 5px;
            line-height: 1.5;
        }

        .popular-content small {
            color: #6c757d;
        }
    </style>
    <div class="container shared-post-wrapper">

        <div class="row g-4">


            <div class="col-lg-8">
                <div class="shared-post-card">

                    <div class="author-info">

                        <img src="{{ get_image($post->user->image) }}" alt="">

                        <div>
                            <h6>{{ $post->user->name }}</h6>

                            <small class="text-muted">
                                {{ $post->created_at->format('F j, Y') }}
                            </small>
                        </div>

                    </div>

                    @if ($post->file)
                        <div class="post-media">

                            @if ($post->file_type == 'image')
                                <img src="{{ get_image($post->file) }}" alt="">
                            @elseif($post->file_type == 'video')
                                <video controls>
                                    <source src="{{ asset($post->file) }}">
                                </video>
                            @endif

                        </div>
                    @endif

                    @if ($post->description)
                        <div class="post-description">
                            {{ $post->description }}
                        </div>
                    @endif

                </div>

            </div>


            <div class="col-lg-4">
                <div class="sidebar-card">

                    <h4 class="sidebar-title">
                        {{ get_phrase('Popular Posts') }}
                    </h4>

                    @foreach ($popular_posts as $item)
                        <a href="{{ route('shared.post', $item->id) }}" class="popular-post-item">

                            <div class="popular-thumb">

                                @if ($item->file_type == 'image' && $item->file)
                                    <img src="{{ get_image($item->file) }}" alt="">
                                @elseif($item->file_type == 'video')
                                    <video muted>
                                        <source src="{{ asset($item->file) }}">
                                    </video>
                                @endif

                            </div>

                            <div class="popular-content">

                                <h6>
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 20) }}
                                </h6>

                                <small>
                                    {{ $item->created_at->format('M d, Y') }}
                                </small>

                            </div>

                        </a>
                    @endforeach

                </div>

            </div>

        </div>

    </div>
@endsection
@push('js')
@endpush
