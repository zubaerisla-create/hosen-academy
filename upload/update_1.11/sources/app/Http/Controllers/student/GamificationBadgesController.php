<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Badge;
use App\Models\Blog;
use App\Models\Review;
use App\Models\Watch_history;
use App\Models\Payment_history;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GamificationBadgesController extends Controller
{
public function index()
{
    $user_id = auth()->user()->id;

    $all_badges = [];

    // --------------------------------------
    // 1. Student Badges
    // --------------------------------------

    // Completed course count
    $completed_course_count = Watch_history::where('student_id', $user_id)
        ->whereNotNull('completed_date')
        ->count();

    $course_completed_badge = Badge::where('type','course_completed')
        ->where('condition_from','<=',$completed_course_count)
        ->where('condition_to','>=',$completed_course_count)
        ->first();

    if (!$course_completed_badge) {
        $course_completed_badge = Badge::where('type','course_completed')
            ->where('condition_to','<',$completed_course_count)
            ->orderBy('condition_to','desc')
            ->first();
    }

    if ($course_completed_badge) {
        $all_badges[] = $course_completed_badge;
    }

    // Certificate badge
    $certificate_count = Certificate::where('user_id',$user_id)->count();

    $certificate_badge = Badge::where('type','course_certificates')
        ->where('condition_from','<=',$certificate_count)
        ->where('condition_to','>=',$certificate_count)
        ->first();

    if (!$certificate_badge) {
        $certificate_badge = Badge::where('type','course_certificates')
            ->where('condition_to','<',$certificate_count)
            ->orderBy('condition_to','desc')
            ->first();
    }

    if ($certificate_badge) {
        $all_badges[] = $certificate_badge;
    }

    // --------------------------------------
    // 2. Instructor Badges (if role = instructor)
    // --------------------------------------

    $user = User::find($user_id);

    if ($user && $user->role == 'instructor') { 

        // Total courses
        $course_count = Course::where('status','active')
            ->where('user_id', $user_id)
            ->count();

        // Course IDs
        $course_ids = Course::where('user_id', $user_id)->pluck('id')->toArray();

        // Course sales
        $course_sale_count = !empty($course_ids)
            ? Payment_history::whereIn('course_id', $course_ids)->count()
            : 0;

        // Total blogs
        $article_count = Blog::where('user_id', $user_id)->count();

        // Total reviews
        $total_reviews = !empty($course_ids)
            ? Review::whereIn('course_id', $course_ids)->count()
            : 0;

        // Course count badge
        $earned_badge = Badge::where('type','course_count')
            ->where('condition_from','<=',$course_count)
            ->where('condition_to','>=',$course_count)
            ->first();

        if (!$earned_badge) {
            $earned_badge = Badge::where('type','course_count')
                ->where('condition_to','<',$course_count)
                ->orderBy('condition_to','desc')
                ->first();
        }

        // Sale badge
        $sale_badge = Badge::where('type','course_sale')
            ->where('condition_from','<=',$course_sale_count)
            ->where('condition_to','>=',$course_sale_count)
            ->first();

        if (!$sale_badge) {
            $sale_badge = Badge::where('type','course_sale')
                ->where('condition_to','<',$course_sale_count)
                ->orderBy('condition_to','desc')
                ->first();
        }

        // Blog badge
        $article_badge = Badge::where('type','blog')
            ->where('condition_from','<=',$article_count)
            ->where('condition_to','>=',$article_count)
            ->first();

        // Review badge
        $review_badge = Badge::where('type','course_ratings')
            ->where('condition_from','<=',$total_reviews)
            ->where('condition_to','>=',$total_reviews)
            ->first();

        if (!$review_badge) {
            $review_badge = Badge::where('type','course_ratings')
                ->where('condition_to','<',$total_reviews)
                ->orderBy('condition_to','desc')
                ->first();
        }

        // Add non-null instructor badges to the array
        foreach ([$earned_badge, $sale_badge, $article_badge, $review_badge] as $badge) {
            if ($badge) {
                $all_badges[] = $badge;
            }
        }
    }

    // --------------------------------------
    // Pass data to view
    // --------------------------------------
    return view(
        'frontend.' . get_frontend_settings('theme') . '.student.gamification-badges.index',
        compact('all_badges')
    );
}
}
