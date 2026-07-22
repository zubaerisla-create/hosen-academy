<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\CommunityComment;
use App\Models\CommunityLike;
use App\Models\CommunityPost;
use App\Models\CommunitySavedPost;
use App\Models\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CommunityController extends Controller
{

    public function index(Request $request)
    {
        $query = CommunityPost::with('user')->latest();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $page_data['posts'] = $query->paginate(6);

        return view(theme_path() . 'community.index', $page_data);
    }

    public function post_store(Request $request)
    {
        $request->validate([
            'user_id' => "required",
        ]);

        $data['user_id']     = $request->user_id;
        $data['description'] = $request->description;

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $directory = public_path('uploads/posts');

            if (! File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $filename = nice_file_name(
                $request->user_id,
                $file->extension()
            );

            $path = 'uploads/posts/' . $filename;

            if (str_starts_with($file->getMimeType(), 'image/')) {

                FileUploader::upload($file, $path, 400, null, 200, 200);

                $data['file_type'] = 'image';

            } elseif (str_starts_with($file->getMimeType(), 'video/')) {

                $file->move($directory, $filename);

                $data['file_type'] = 'video';
            }

            $data['file'] = $path;
        }

        CommunityPost::insert($data);

        return redirect(route('posts'))->with('success', get_phrase('Post created successfully'));

    }

    public function toggle_like($id)
    {
        $post = CommunityPost::findOrFail($id);

        $like = CommunityLike::where('post_id', $post->id)->where('user_id', auth()->id())->first();

        if ($like) {

            $like->delete();

            $post->decrement('total_likes');

            return response()->json([
                'status'      => 'unliked',
                'total_likes' => $post->fresh()->total_likes,
            ]);
        }

        CommunityLike::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        $post->increment('total_likes');

        return response()->json([
            'status'      => 'liked',
            'total_likes' => $post->fresh()->total_likes,
        ]);
    }

    public function toggle_save($id)
    {
        $post = CommunityPost::findOrFail($id);

        $savedPost = CommunitySavedPost::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($savedPost) {

            $savedPost->delete();

            return response()->json([
                'status'  => 'unsaved',
                'message' => 'Post removed from bookmark list',
            ]);
        }

        CommunitySavedPost::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'status'  => 'saved',
            'message' => 'Post bookmarked successfully',
        ]);
    }

    public function saved_posts()
    {
        $savedPosts = CommunitySavedPost::with('post')->where('user_id', auth()->id())->latest()->paginate(10);

        return view(theme_path() . 'community.saved_posts', compact('savedPosts'));
    }

    public function remove_saved_post($id)
    {
        CommunitySavedPost::where('post_id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->route('saved.posts')->with('success', get_phrase('Bookmark removed successfully'));
    }

    public function my_posts()
    {
        $posts = CommunityPost::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view(theme_path() . 'community.my_posts', compact('posts'));
    }

    public function delete_post($id, $source = null)
    {
        $post = CommunityPost::findOrFail($id);

        if ($post->user_id != auth()->id()) {
            abort(403);
        }

        CommunityLike::where('post_id', $post->id)->delete();

        CommunitySavedPost::where('post_id', $post->id)->delete();

        CommunityComment::where('post_id', $post->id)->delete();

        if ($post->file && file_exists(public_path($post->file))) {

            unlink(public_path($post->file));
        }

        $post->delete();

        if ($source == 'posts') {
            return redirect()->route('posts')
                ->with('success', get_phrase('Post deleted successfully'));
        }

        return redirect()->route('my.posts')->with('success', get_phrase('Post deleted successfully'));

    }

    public function store_comment(Request $request, $id)
    {
        if (! auth()->check()) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Please login first',
            ]);
        }

        $request->validate([
            'comment' => 'required',
        ]);

        $post = CommunityPost::findOrFail($id);

        CommunityComment::create([
            'post_id'   => $post->id,
            'user_id'   => auth()->id(),
            'parent_id' => $request->parent_id,
            'comment'   => $request->comment,
            'status'    => 1,
        ]);

        $post->increment('total_comments');

        return response()->json([
            'status'         => 'success',
            'message'        => 'Comment added successfully',
            'total_comments' => $post->fresh()->total_comments,
        ]);
    }

    public function shared_post($id)
    {
        $post = CommunityPost::with('user')
            ->findOrFail($id);

        $popular_posts = CommunityPost::where('id', '!=', $id)
            ->latest()
            ->get();

        return view(theme_path() . 'community.shared_post', compact('post', 'popular_posts'));
    }

}
