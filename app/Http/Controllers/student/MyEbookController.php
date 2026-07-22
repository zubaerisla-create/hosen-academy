<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\EbookPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MyEbookController extends Controller
{
    public function index()
    {
        $page_data['my_ebooks'] = EbookPurchase::join('ebooks', 'ebook_purchases.ebook_id', '=', 'ebooks.id')
            ->join('users', 'ebooks.user_id', '=', 'users.id')
            ->where('ebook_purchases.user_id', auth()->user()->id)
            ->select('ebook_purchases.*', 'ebooks.slug', 'ebooks.title', 'ebooks.thumbnail', 'users.name as user_name', 'users.photo as user_photo')
            ->paginate(6);

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.my_ebooks.index';
        return view($view_path, $page_data);
    }

    public function preview($id)
    {
        // Check database
        $ebook = Ebook::where('id', $id)->first();
        if (! $ebook) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // File exists check
        $file = public_path($ebook->preview);
        if (! file_exists($file)) {
            Session::flash('error', get_phrase('File does not exist.'));
            return redirect()->back();
        }

        return response()->file($file, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="preview.pdf"',
            'Cache-Control' => 'private, no-store, no-cache, must-revalidate',
        ]);
    }

    public function read($slug)
    {
        if (! auth()->check()) {
            Session::flash('error', get_phrase('Please log in to read your purchased eBooks.'));
            return redirect()->route('login');
        }

        $ebook = Ebook::where('slug', $slug)->first();
        if (! $ebook) {
            Session::flash('error', get_phrase('eBook not found.'));
            return redirect()->route('my.ebooks');
        }

        // Purchase ownership check
        $user = auth()->user();
        $is_purchased = EbookPurchase::where('user_id', $user->id)
            ->where('ebook_id', $ebook->id)
            ->exists();

        $is_owner_or_admin = ($user->role == 'admin' || $user->role == 'instructor' || $ebook->user_id == $user->id);

        if (! $is_purchased && ! $is_owner_or_admin) {
            Session::flash('error', get_phrase('You must purchase this eBook to read it.'));
            return redirect()->route('ebook.details', $ebook->slug);
        }

        // Verify PDF file existence on disk
        $file_path = public_path($ebook->complete);
        if (empty($ebook->complete) || ! file_exists($file_path)) {
            Session::flash('error', get_phrase('The eBook PDF file is currently unavailable. Please contact support.'));
            return redirect()->route('my.ebooks');
        }

        $page_data['ebook'] = $ebook;
        $page_data['page_title'] = get_phrase('Reading') . ': ' . $ebook->title;
        $page_data['stream_url'] = route('my.ebooks.stream', $ebook->slug);

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.my_ebooks.read_reader';
        return view($view_path, $page_data);
    }

    public function stream_pdf(Request $request, $slug)
    {
        if (! auth()->check()) {
            abort(401, 'Unauthorized');
        }

        $ebook = Ebook::where('slug', $slug)->firstOrFail();
        $user = auth()->user();

        // Ownership verification
        $is_purchased = EbookPurchase::where('user_id', $user->id)
            ->where('ebook_id', $ebook->id)
            ->exists();

        $is_owner_or_admin = ($user->role == 'admin' || $user->role == 'instructor' || $ebook->user_id == $user->id);

        if (! $is_purchased && ! $is_owner_or_admin) {
            abort(403, 'Forbidden: You have not purchased this eBook.');
        }

        $file_path = public_path($ebook->complete);
        if (empty($ebook->complete) || ! file_exists($file_path)) {
            abort(404, 'File not found');
        }

        return response()->file($file_path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="reader-stream.pdf"',
            'Cache-Control' => 'private, no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
