<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Badge;
use App\Models\Blog;
use App\Models\Payment_history;
use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InstructorController extends Controller
{
    public function index()
    {
        $page_data['instructors'] = User::where('role', 'instructor')->latest('id')->paginate(8);
        $view_path                = 'frontend.' . get_frontend_settings('theme') . '.instructor.index';
        return view($view_path, $page_data);
    }

  public function show($name, $id)
{
    // Instructor fetch
    $instructor = User::find($id);

    if (!$instructor) {
        Session::flash('error', get_phrase('Instructor not found.'));
        return redirect()->back();
    }

    // Instructor courses (paginate 6)
    $instructor_courses = Course::where('status', 'active')
        ->where(function ($query) use ($instructor) {
            $query->where('user_id', $instructor->id)
                  ->orWhereJsonContains('instructor_ids', (string)$instructor->id);
        })
        ->latest('id')
        ->paginate(6);

    /*
    |--------------------------------------------------------------------------
    | Instructor Stats
    |--------------------------------------------------------------------------
    */

    // Total courses
    $course_count = Course::where('status','active')
        ->where('user_id',$instructor->id)
        ->count();

    // Instructor course IDs
    $course_ids = Course::where('user_id', $instructor->id)->pluck('id')->toArray();

    // Total course sales
    $course_sale_count = 0;
    if (!empty($course_ids)) {
        $course_sale_count = Payment_history::whereIn('course_id', $course_ids)->count();
    }

    // Total blogs
    $article_count = Blog::where('user_id',$instructor->id)->count();

    // Total reviews (for Review Count Badge)
    $total_reviews = 0;
    if (!empty($course_ids)) {
        $total_reviews = Review::whereIn('course_id', $course_ids)->count();
    }

    /*
    |--------------------------------------------------------------------------
    | Badges
    |--------------------------------------------------------------------------
    */

    // Course count badge 
    $earned_badge = Badge::where('type','course_count')
        ->where('condition_from','<=',$course_count)
        ->where('condition_to','>=',$course_count)
        ->first();

    // Course sale badge 
    $sale_badge = Badge::where('type', 'course_sale')
        ->where('condition_from', '<=', $course_sale_count)
        ->where('condition_to', '>=', $course_sale_count)
        ->first();

    if (!$sale_badge) {
        $sale_badge = Badge::where('type', 'course_sale')
            ->where('condition_to', '<', $course_sale_count)
            ->orderBy('condition_to', 'desc')
            ->first();
    }

    // Blog badge 
    $article_badge = Badge::where('type','blog')
        ->where('condition_from','<=',$article_count)
        ->where('condition_to','>=',$article_count)
        ->first();

    // ----------------------------
    // Review Count Badge 
    // ----------------------------
    $review_badge = Badge::where('type', 'course_ratings')
        ->where('condition_from', '<=', $total_reviews)
        ->where('condition_to', '>=', $total_reviews)
        ->first();

    if (!$review_badge) {
        $review_badge = Badge::where('type', 'course_ratings')
            ->where('condition_to', '<', $total_reviews)
            ->orderBy('condition_to', 'desc')
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Pass data to view
    |--------------------------------------------------------------------------
    */

    $page_data = [
        'instructor_details' => $instructor,
        'instructor_courses' => $instructor_courses,
        'earned_badge'       => $earned_badge,
        'sale_badge'         => $sale_badge,
        'article_badge'      => $article_badge,
        'review_badge'       => $review_badge, 
    ];

    // Dynamic view path 
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.instructor.details';

    return view($view_path, $page_data);
}
  


}