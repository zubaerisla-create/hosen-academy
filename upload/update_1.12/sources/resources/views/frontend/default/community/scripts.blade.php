<script>
    const isLoggedIn = @json(auth()->check());

    //  Start file upload function
    $(document).ready(function() {

        $('#postFile').on('change', function() {

            let file = this.files[0];

            if (file) {

                $('#fileName').text(file.name);

                $('#selectedFile').removeClass('d-none');
            }
        });

        $('#removeFile').on('click', function() {

            $('#postFile').val('');

            $('#fileName').text('');

            $('#selectedFile').addClass('d-none');
        });

    });
    //  End file upload function


    //  Start post like function
    $(document).on('click', '.toggleLikeBtn', function(e) {

        e.preventDefault();

        if (!isLoggedIn) {
            error('Please login first');
            return false;
        }

        let button = $(this);
        let postId = button.data('post-id');

        $.ajax({
            url: "{{ url('post/like') }}/" + postId,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {

                $('.likeCount' + postId).text(response.total_likes);

                if (response.status == 'liked') {
                    button.addClass('liked-post');
                } else {
                    button.removeClass('liked-post');
                }
            }
        });
    });
    //  End post like function

    //  Start post comment function
    $(document).on('click', '.toggleCommentSection', function(e) {

        e.preventDefault();

        if (!isLoggedIn) {
            error('Please login first');
            return false;
        }

        let postId = $(this).data('post-id');

        $('#commentSection' + postId).toggleClass('d-none');
    });

    $(document).on('click', '.replyBtn', function() {

        let commentId = $(this).data('comment-id');

        $('#replyForm' + commentId).toggleClass('d-none');
    });

    $(document).on('submit', '.commentForm', function(e) {

        e.preventDefault();

        let form = $(this);
        let postId = form.data('post-id');

        $.ajax({

            url: "{{ url('post/comment') }}/" + postId,

            type: "POST",

            data: {
                _token: "{{ csrf_token() }}",
                comment: form.find('[name="comment"]').val()
            },

            success: function(response) {

                success(response.message);

                location.reload();
            }
        });

    });

    $(document).on('submit', '.replyForm', function(e) {

        e.preventDefault();

        let form = $(this);
        let postId = form.data('post-id');

        $.ajax({

            url: "{{ url('post/comment') }}/" + postId,

            type: "POST",

            data: {
                _token: "{{ csrf_token() }}",
                parent_id: form.data('parent-id'),
                comment: form.find('[name="comment"]').val()
            },

            success: function(response) {

                success(response.message);

                location.reload();
            }
        });

    });

    $(document).on('click', '.toggleRepliesBtn', function() {

        let commentId = $(this).data('comment-id');

        let container = $('#repliesContainer' + commentId);

        if (container.hasClass('d-none')) {

            container.removeClass('d-none');

            $(this).text('Hide replies');

        } else {

            container.addClass('d-none');

            let totalReplies =
                container.find('.reply-item').length;

            $(this).text('Show ' + totalReplies + ' replies');
        }
    });
    //  End post comment function

    //  Start post share link copy function
    $(document).on('click', '.sharePostBtn', function() {

        let url = $(this).data('url');

        navigator.clipboard.writeText(url).then(function() {
            success('Post link copied successfully');
        }).catch(function() {
            warning('Failed to copy link');
        });
    });
    //  End post share link copy function
</script>

{{-- Start bookmark add --}}
<script>
    $(document).on('click', '.savePostBtn', function(e) {

        e.preventDefault();

        if (!isLoggedIn) {
            error('Please login first');
            return false;
        }

        let button = $(this);
        let postId = button.data('post-id');

        $.ajax({
            url: "{{ url('post/save') }}/" + postId,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {

                if (response.status == 'saved') {

                    button.text('Remove Bookmark');

                    success(response.message);

                } else {

                    button.text('Bookmark');

                    success(response.message);
                }
            }
        });
    });
</script>
{{-- End bookmark add --}}
