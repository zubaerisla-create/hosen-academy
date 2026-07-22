 <div class="comment-section d-none mt-3" id="commentSection{{ $post->id }}">
     <div class="comment-wrapper">

         <h5 class="mb-4">{{ get_phrase('Comments') }} ({{ $post->total_comments }})</h5>

         @auth
             <div class="comment-form-area">

                 <img src="{{ get_image(auth()->user()->photo ?? '') }}" class="comment-user-image">

                 <div class="comment-form-content">

                     <form class="commentForm" data-post-id="{{ $post->id }}">

                         <textarea name="comment" class="form-control" rows="3" placeholder="Add a comment..."></textarea>

                         <div class="text-end mt-3">
                             <button type="submit" class="post-comment-btn"><i class="far fa-paper-plane px-2"></i>{{ get_phrase('Post Comment') }}</button>
                         </div>

                     </form>

                 </div>

             </div>

             <hr>
         @endauth

         <div class="comment-list">

             @foreach ($post->comments as $comment)
                 <div class="comment-item">

                     <div class="d-flex">

                         <img src="{{ get_image($comment->user->photo ?? '') }}" class="comment-user-image me-3">

                         <div class="flex-grow-1">

                             <div class="comment-box">

                                 <div class="d-flex justify-content-between">

                                     <strong>
                                         {{ $comment->user->name }}
                                     </strong>

                                     <small class="text-muted">
                                         {{ $comment->created_at->diffForHumans() }}
                                     </small>

                                 </div>

                                 <div class="mt-1">
                                     {{ $comment->comment }}
                                 </div>

                             </div>

                             <a href="javascript:void(0)" class="replyBtn" data-comment-id="{{ $comment->id }}">
                                 {{ get_phrase('Reply') }}
                             </a>

                             @if ($comment->replies->count() > 0)
                                 <a href="javascript:void(0)" class="toggleRepliesBtn" data-comment-id="{{ $comment->id }}">

                                     {{ get_phrase('Show') }} {{ $comment->replies->count() }} {{ get_phrase('replies') }}
                                 </a>
                             @endif


                             <div class="replyFormArea d-none mt-2" id="replyForm{{ $comment->id }}">

                                 <form class="replyForm" data-post-id="{{ $post->id }}" data-parent-id="{{ $comment->id }}">

                                     <textarea name="comment" class="form-control" rows="2" placeholder="Write a reply..."></textarea>

                                     <div class="text-end mt-2 d-flex gap-2 justify-content-end">
                                         <a href="javascript:void(0)" class="replyBtn post-replay-cancel-btn" data-comment-id="{{ $comment->id }}">
                                             {{ get_phrase('Cancel') }}
                                         </a>

                                         <button class="post-replay-btn">
                                             <i class="far fa-paper-plane px-2"></i>
                                             {{ get_phrase('Reply') }}
                                         </button>

                                     </div>

                                 </form>

                             </div>

                             <div class="repliesContainer d-none" id="repliesContainer{{ $comment->id }}">

                                 @foreach ($comment->replies as $reply)
                                     <div class="reply-item">

                                         <img src="{{ get_image($reply->user->photo ?? '') }}" class="reply-user-image">

                                         <div class="comment-box flex-grow-1">

                                             <div class="d-flex justify-content-between">

                                                 <strong>
                                                     {{ $reply->user->name }}
                                                 </strong>

                                                 <small class="text-muted">
                                                     {{ $reply->created_at->diffForHumans() }}
                                                 </small>

                                             </div>

                                             <div class="mt-1">
                                                 {{ $reply->comment }}
                                             </div>

                                         </div>

                                     </div>
                                 @endforeach

                             </div>

                         </div>

                     </div>

                     <hr>

                 </div>
             @endforeach

         </div>

     </div>

 </div>
