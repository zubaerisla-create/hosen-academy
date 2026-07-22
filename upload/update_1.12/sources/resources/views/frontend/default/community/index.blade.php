@extends('layouts.default')
@push('title', get_phrase('Posts'))
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

                            <h2>{{ get_phrase('Community Posts') }}</h2>
                            <p>{{ get_phrase('Connect, share, and learn together') }}</p>

                            <div class="community-toolbar mt-3">

                                <div class="row align-items-center">

                                    <div class="col-md-8">
                                        <form method="GET" action="{{ route('posts') }}">
                                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ get_phrase('Search posts...') }}">
                                        </form>
                                    </div>

                                    <div class="col-md-4 text-end">

                                        <button type="button" class="create-post-btn" id="showPostForm">
                                            <i class="fas fa-plus px-2"></i>
                                            {{ get_phrase('Create Post') }}
                                        </button>

                                        <button type="button" class="cancel-post-btn d-none" id="hidePostForm">
                                            <i class="fas fa-times px-2"></i>{{ get_phrase('Cancel') }}
                                        </button>

                                    </div>

                                </div>

                            </div>
                            <form action="{{ route('post.store') }}" method="POST" id="postFormCard" class="d-none" enctype="multipart/form-data">
                                @csrf

                                <div class="create-post-card">

                                    <input type="hidden" name="user_id" value="{{ $auth->id ?? '' }}">

                                    <div class="create-post-body">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ get_image($auth->photo ?? '') }}" class="post-user-img">
                                            <div><strong>{{ $auth->name ?? '' }}</strong></div>
                                        </div>
                                        <textarea name="description" class="form-control post-textarea" placeholder="Share your thoughts with the community..."></textarea>
                                    </div>

                                    <div class="create-post-footer">
                                        <div>
                                            <label class="upload-btn"><i class="far fa-image"></i>{{ get_phrase('Photo/Video') }}<input type="file" name="file" id="postFile" hidden accept="image/*,video/*"></label>
                                            <div id="selectedFile" class="selected-file d-none">
                                                <span id="fileName"></span>
                                                <button type="button" id="removeFile"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn-submit-post">{{ get_phrase('Post') }}</button>
                                    </div>
                                </div>
                            </form>


                            @forelse ($posts as $post)
                                <div class="post-card">
                                    <div class="post-header">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ get_image($post->user->photo) }}" class="post-user-img">
                                            <div>
                                                <strong>{{ $post->user->name }}</strong><br>
                                                <small>{{ $post->created_at->format('F j, g:i A') }}</small>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn post-option-btn" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @php
                                                    $isSaved = auth()->check()
                                                        ? \App\Models\CommunitySavedPost::where('post_id', $post->id)
                                                            ->where('user_id', auth()->id())
                                                            ->exists()
                                                        : false;
                                                @endphp
                                                <li>
                                                    <a href="javascript:void(0)" class="dropdown-item savePostBtn" data-post-id="{{ $post->id }}">

                                                        {{ $isSaved ? get_phrase('Remove Bookmark') : get_phrase('Bookmark') }}
                                                    </a>
                                                </li>
                                                @if ($auth && $post->user_id == $auth->id)
                                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="confirmModal('{{ route('post.delete', [$post->id, 'posts']) }}')">{{ get_phrase('Delete') }}</a></li>
                                                @endif
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
                                        <small><span class="likeCount{{ $post->id }}">{{ $post->total_likes }}</span> {{ get_phrase('likes') }}</small>
                                        <small><span class="commentCount{{ $post->id }}">{{ $post->total_comments }}</span> {{ get_phrase('comments') }}</small>
                                    </div>

                                    <div class="post-footer">
                                        @php
                                            $isLiked = \App\Models\CommunityLike::where('post_id', $post->id)
                                                ->where('user_id', auth()->id())
                                                ->exists();
                                        @endphp
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

                            @if (count($posts) > 0)
                                <div class="entry-pagination">
                                    {{ $posts->withQueryString()->links() }}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.default.community.scripts')
@endsection
@push('js')
    <script>
        $(document).ready(function() {

            $('#showPostForm').on('click', function() {

                if (!isLoggedIn) {
                    error('Please login first');
                    return;
                }

                $('#postFormCard').removeClass('d-none');

                $(this).addClass('d-none');

                $('#hidePostForm').removeClass('d-none');
            });

            $('#hidePostForm').on('click', function() {

                $('#postFormCard').addClass('d-none');

                $(this).addClass('d-none');

                $('#showPostForm').removeClass('d-none');
            });

        });
    </script>
@endpush
