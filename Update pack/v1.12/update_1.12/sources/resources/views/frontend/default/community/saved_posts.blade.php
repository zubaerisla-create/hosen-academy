@extends('layouts.default')
@push('title', get_phrase('Saved Posts'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $auth = auth()->user();
    @endphp
    <section class="breadcum-area"></section>

    <div class="eNtery-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">

                    @include('frontend.default.community.sidebar')

                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="row">
                        <div class="community-content">
                            <h2>{{ get_phrase('Saved Posts') }}</h2>

                            @forelse ($savedPosts as $savedPost)
                                @php
                                    $post = $savedPost->post;

                                    if (!$post) {
                                        continue;
                                    }

                                    $isLiked = auth()->check()
                                        ? \App\Models\CommunityLike::where('post_id', $post->id)
                                            ->where('user_id', auth()->id())
                                            ->exists()
                                        : false;
                                @endphp

                                <div id="savedPostsContainer" class="post-card saved-post-{{ $post->id }}">
                                    <div class="post-header">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ get_image($post->user->photo ?? '') }}" class="post-user-img">
                                            <div>
                                                <strong>{{ $post->user->name ?? '' }}</strong><br>
                                                <small>{{ date('F j, Y g:i A', strtotime($post->created_at)) }}</small>
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <button class="btn post-option-btn" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="{{ route('remove.saved.post', $post->id) }}" class="dropdown-item">
                                                        {{ get_phrase('Remove Bookmark') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="post-body">

                                        @if ($post->description)
                                            <p>{!! nl2br(e($post->description)) !!}</p>
                                        @endif

                                        @if ($post->file)
                                            @if ($post->file_type == 'image')
                                                <img src="{{ get_image($post->file) }}" class="post-image">
                                            @elseif($post->file_type == 'video')
                                                <video controls class="w-100">
                                                    <source src="{{ asset($post->file) }}" type="video/mp4">
                                                    {{ get_phrase('Your browser does not support the video tag.') }}
                                                </video>
                                            @endif
                                        @endif

                                    </div>

                                    <div class="d-flex align-items-center gap-4 px-4 py-2">
                                        <small>
                                            <span class="likeCount{{ $post->id }}">
                                                {{ $post->total_likes }}
                                            </span>
                                            {{ get_phrase('likes') }}
                                        </small>

                                        <small>
                                            <span class="commentCount{{ $post->id }}">
                                                {{ $post->total_comments }}
                                            </span>
                                            {{ get_phrase('comments') }}
                                        </small>
                                    </div>

                                    <div class="post-footer">

                                        <a href="javascript:void(0)" class="toggleLikeBtn {{ $isLiked ? 'liked-post' : '' }}" data-post-id="{{ $post->id }}">

                                            <i class="far fa-thumbs-up"></i>
                                            {{ get_phrase('Like') }}
                                        </a>

                                        <a href="javascript:void(0)" class="toggleCommentSection" data-post-id="{{ $post->id }}">

                                            <i class="far fa-comment"></i>
                                            {{ get_phrase('Comment') }}
                                        </a>
                                        <a href="javascript:void(0)" class="sharePostBtn" data-url="{{ route('shared.post', $post->id) }}">
                                            <i class="fas fa-share"></i>
                                            {{ get_phrase('Share') }}
                                        </a>
                                    </div>

                                    @include('frontend.default.community.comments')

                                </div>
                            @empty
                                <div class="col-12 bg-white radius-20 mt-4">
                                    @include('frontend.default.empty')
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.default.community.scripts')

@endsection
@push('js')
@endpush
