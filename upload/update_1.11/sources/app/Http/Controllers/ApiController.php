<?php
namespace App\Http\Controllers;

use App\Models\Bootcamp;
use App\Models\BootcampLiveClass;
use App\Models\BootcampModule;
use App\Models\BootcampResource;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\FileUploader;
use App\Models\Language;
use App\Models\Live_class;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\Payment_history;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketMessage;
use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\User;
use App\Models\Wishlist;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class ApiController extends Controller
{

    //student login function
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->where('status', 1)->first();

        // Check password
        if (! $user || ! Hash::check($fields['password'], $user->password)) {
            if (isset($user) && $user->count() > 0) {
                return response([
                    'message' => 'Invalid credentials!',
                ], 401);
            } else {
                return response([
                    'message' => 'User not found!',
                ], 401);
            }
        } else if ($user->role == 'student') {

            // $user->tokens()->delete();

            $token = $user->createToken('auth-token')->plainTextToken;

            $user->photo = get_photo('user_image', $user->photo);

            $response = [
                'message' => 'Login successful',
                'user'    => $user,
                'token'   => $token,
            ];

            return response($response, 201);
        } else {

            //user not authorized
            return response()->json([
                'message' => 'User not found!',
            ], 400);
        }
    }

    public function signup1(Request $request)
    {
        // return $request->all();
        $response = [];

        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
        $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails()) {
        //     return json_encode(array('validationError' => $validator->getMessageBag()->toArray()));
        // }
        // if ($validator->fails()) {
        //     return response()->json(['validationError' => $validator->errors()], 422);
        // }
        // return $response;
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'role' => 'student',
        //     'password' => Hash::make($request->password),
        //     'status' => 1,
        // ]);
        $user_data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'student',
            'status'   => 1,
            'password' => Hash::make($request->password),
        ];

        if (get_settings('student_email_verification') != 1) {
            $user_data['email_verified_at'] = date('Y-m-d H:i:s');
        }

        $user = User::create($user_data);

        if (get_settings('student_email_verification') == 1) {
            $user->sendEmailVerificationNotification();
        }

        if ($user) {
            $response['success'] = true;
            $response['message'] = 'user create successfully';
        }
        // event(new Registered($user));

        return $response;
    }

    public function signup(Request $request)
    {
        // send a type = registration with this api
        try {
            // Validation rules
            $rules = [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ];

            // Validate the request
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ], 422);
            }

            // Prepare user data
            $user_data = [
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => 'student',
                'status'   => 1,
                'password' => Hash::make($request->password),
            ];

            // Check if email verification is required
            $verificationRequired = get_settings('student_email_verification') ?? 0;
            if ($verificationRequired != 1) {
                $user_data['email_verified_at'] = date('Y-m-d H:i:s');
            }

            // Create the user
            $user = User::create($user_data);

            // Send email verification if required
            if ($verificationRequired == 1) {
                $user->sendEmailVerificationNotification();
            }

            // Return success response
            return response()->json([
                'success'                    => true,
                'message'                    => 'User created successfully',
                'student_email_verification' => $verificationRequired,
                'data'                       => $user,
            ], 201);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error during signup: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the user.',
            ], 500);
        }
    }

    //     public function signup(Request $request)
    // {
    //     $response = [];

    //     $rules = [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ];

    //     $validator = Validator::make($request->all(), $rules);
    //     if ($validator->fails()) {
    //         return response()->json(['validationError' => $validator->errors()], 422);
    //     }

    //     $user_data = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role' => 'student',
    //         'status' => 1,
    //         'password' => Hash::make($request->password),
    //     ];

    //     if (get_settings('student_email_verification') != 1) {
    //         $user_data['email_verified_at'] = now();
    //     }

    //     $user = User::create($user_data);

    //     if (get_settings('student_email_verification') == 1) {
    //         $user->sendEmailVerificationNotification();
    //     }

    //     if ($user) {
    //         $response = [
    //             'success' => true,
    //             'message' => 'User created successfully',
    //         ];
    //     } else {
    //         $response = [
    //             'success' => false,
    //             'message' => 'User creation failed',
    //         ];
    //     }

    //     event(new Registered($user));

    //     return response()->json($response);
    // }

    //student logout function
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete;

        return response()->json([
            'message' => 'Logged out successfully.',
        ], 201);
    }

    // forgot password
    // public function forgot_password(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     if ($status == Password::RESET_LINK_SENT) {
    //         return back()->with('status', __($status));
    //     }

    //     throw ValidationException::withMessages([
    //         'email' => [trans($status)],
    //     ]);
    // }

    public function forgot_password(Request $request)
    {
        $response = [];

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            $response['success'] = true;
            $response['message'] = 'Reset Password Link sent successfully to your email.';
            return response()->json($response, 200);
        }

        $response['success'] = false;
        $response['message'] = 'Failed to send Reset Password Link. Please check the email and try again.';
        return response()->json($response, 400);
    }

    // update user data
    public function update_userdata(Request $request)
    {
        $response = [];
        $token    = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user_id = auth('sanctum')->user()->id;

            if ($request->name != "") {
                $data['name'] = htmlspecialchars($request->name, ENT_QUOTES, 'UTF-8');
            } else {
                $response['status']       = 'failed';
                $response['error_reason'] = 'Name cannot be empty';
                return $response;
            }

            $data['biography'] = $request->biography;
            $data['about']     = $request->about;
            $data['address']   = $request->address;
            $data['facebook']  = htmlspecialchars($request->facebook, ENT_QUOTES, 'UTF-8');
            $data['twitter']   = htmlspecialchars($request->twitter, ENT_QUOTES, 'UTF-8');
            $data['linkedin']  = htmlspecialchars($request->linkedin, ENT_QUOTES, 'UTF-8');

            if ($request->hasFile('photo')) {
                $file      = $request->file('photo');
                $file_name = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $path      = 'assets/upload/users/' . auth('sanctum')->user()->role . '/' . $file_name;

                // Assuming FileUploader::upload() is a method that uploads the file
                FileUploader::upload($file, $path, null, null, 300);

                // Save the path to the database
                $data['photo'] = $path;
            }

            User::where('id', $user_id)->update($data);

            $user        = auth('sanctum')->user();
            $user->photo = get_photo('user_image', $user->photo);

            $updated_user          = User::find($user_id);
            $updated_user['photo'] = url('public/' . $updated_user['photo']);

            $response['status']       = 'success';
            $response['user']         = $updated_user;
            $response['error_reason'] = 'None';
        } else {
            $response['status']       = 'failed';
            $response['error_reason'] = 'Unauthorized login';
        }

        return $response;
    }

    //
    public function top_courses($top_course_id = "")
    {
        $query = Course::orderBy('id', 'desc')->where('status', 'active')->limit(10)->get();

        if ($top_course_id != "") {
            $query->where('id', $top_course_id);
        }

        $result = course_data($query);

        return $result;
    }

    public function all_categories()
    {
        $all_categories = [];
        $categories     = Category::where('parent_id', 0)->get();
        foreach ($categories as $key => $category) {
            $all_categories[$key]                      = $category;
            $all_categories[$key]['thumbnail']         = get_photo('category_thumbnail', $category['thumbnail']);
            $all_categories[$key]['number_of_courses'] = get_category_wise_courses($category['id'])->count();

            $all_categories[$key]['number_of_sub_categories'] = $category->childs->count();

            // $sub_categories = $category->childs;
        }
        return $all_categories;
    }

    // Get categories
    public function categories($category_id = "")
    {
        if ($category_id != "") {
            $categories = Category::where('id', $category_id)->first();
        } else {
            $categories = Category::where('parent_id', 0)->get();
        }
        foreach ($categories as $key => $category) {
            $categories[$key]['thumbnail']         = get_photo('category_thumbnail', $category['thumbnail']);
            $categories[$key]['number_of_courses'] = get_category_wise_courses($category['id'])->count();

            $categories[$key]['number_of_sub_categories'] = $category->childs->count();
        }
        return $categories;
    }

    // Fetch all the categories
    public function category_details(Request $request)
    {

        $response   = [];
        $categories = [];
        $categories = sub_categories($request->category_id);

        // $response['sub_categories'] = $categories;

        $response[0]['sub_categories'] = $categories;

        $courses = get_category_wise_courses($request->category_id);

        $response[0]['courses'] = course_data($courses);

        // foreach ($response as $key => $resp) {
        //     $response[$key]['sub_categories'] = $categories;
        // }

        return $response;

        // $response['courses'] = $result;

        // return $response;
    }

    // Fetch all the categories
    public function sub_categories($parent_category_id = "")
    {

        $categories = [];
        $categories = sub_categories($parent_category_id);

        return $categories;
    }

    // Fetch all the courses belong to a certain category
    public function category_wise_course(Request $request)
    {
        $category_id = $request->category_id;
        $courses     = get_category_wise_courses($category_id);

        $result = course_data($courses);

        return $result;
    }
    // Fetch all the courses belong to a certain category
    public function category_subcategory_wise_course(Request $request)
    {
        $category_id = $request->category_id;
        $courses     = get_category_wise_courses($category_id);
        $sub         = Category::where('category_id', $category_id)->where('status', 'active')->get();

        $result = course_data($courses);

        return $result;
    }

    // Filter course
    public function filter_course(Request $request)
    {
        // $courses = $this->api_model->filter_course();
        // $this->set_response($courses, REST_Controller::HTTP_OK);

        $selected_category      = $request->selected_category;
        $selected_price         = $request->selected_price;
        $selected_level         = $request->selected_level;
        $selected_language      = $request->selected_language;
        $selected_rating        = $request->selected_rating;
        $selected_search_string = ltrim(rtrim($request->selected_search_string));

        // $course_ids = array();

        $query = Course::query();

        if ($selected_search_string != "" && $selected_search_string != "null") {
            $query->where('title', $selected_search_string->id);
        }
        if ($selected_category != "all") {
            $query->where('category_id', $selected_category);
        }

        if ($selected_price != "all") {
            if ($selected_price == "paid") {
                $query->where('is_paid', 1);
            } elseif ($selected_price == "free") {
                $query->where('is_paid', 0)
                    ->orWhere('is_paid', null);
            }
        }

        if ($selected_level != "all") {
            $query->where('level', $selected_level);
        }

        if ($selected_language != "all") {
            $query->where('language', $selected_language);
        }

        $query->where('status', 'active');
        $courses = $query->get();

        // foreach ($courses as $course) {
        //     if ($selected_rating != "all") {
        //         $total_rating =  $this->crud_model->get_ratings('course', $course['id'], true)->row()->rating;
        //         $number_of_ratings = $this->crud_model->get_ratings('course', $course['id'])->num_rows();
        //         if ($number_of_ratings > 0) {
        //             $average_ceil_rating = ceil($total_rating / $number_of_ratings);
        //             if ($average_ceil_rating == $selected_rating) {
        //                 array_push($course_ids, $course['id']);
        //             }
        //         }
        //     } else {
        //         array_push($course_ids, $course['id']);
        //     }
        // }

        // This block of codes return the required data of courses
        $result = [];
        $result = course_data($courses);
        return $result;
    }

    // Fetch all the courses belong to a certain category
    public function languages()
    {
        $response  = [];
        $languages = Language::select('name')->distinct()->get();

        foreach ($languages as $key => $language) {
            $response[$key]['id']             = $key + 1;
            $response[$key]['value']          = $language->name;
            $response[$key]['displayedValue'] = ucfirst($language->name);
        }

        return $response;
    }

    // Filter course
    public function courses_by_search_string(Request $request)
    {
        $search_string = $request->search_string;

        $courses  = Course::where('title', 'LIKE', "%{$search_string}%")->where('status', 'active')->get();
        $response = course_data($courses);

        return $response;
    }

    // Course Details
    public function course_details_by_id(Request $request)
    {

        $response = [];

        $course_id = $request->course_id;

        $user    = auth('sanctum')->user();
        $user_id = $user ? $user->id : 0;

        if ($user_id > 0) {
            $response = course_details_by_id($user_id, $course_id);
        } else {
            $response = course_details_by_id(0, $course_id);
        }
        return $response;
    }

    //Protected APIs. This APIs will require Authorization.
    // My Courses API
    public function my_courses(Request $request)
    {

        // print_r($request->all());
        // die();
        $token = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user_id = auth('sanctum')->user()->id;

            $my_courses     = [];
            $my_courses_ids = Enrollment::where('user_id', $user_id)->orderBy('id', 'desc')->get();

            foreach ($my_courses_ids as $my_courses_id) {
                $course = Course::find($my_courses_id['course_id']);
                if ($course) {
                    $course_details = course_data([$course])[0]; // get course data

                    // Format expiry_date using PHP date()
                    $raw_expiry                    = $my_courses_id['expiry_date'];
                    $course_details['expiry_date'] = $raw_expiry != null ? date('d M Y', $raw_expiry) : 'Lifetime';

                    // $course_details['accessable'] = my_course_accessable_or_not($my_courses_id['course_id'], $user_id);

                    // Add progress and lesson details
                    $course_details['completion']                        = round(course_progress($course->id, $user_id));
                    $course_details['total_number_of_lessons']           = count(get_lessons('course', $course->id));
                    $course_details['total_number_of_completed_lessons'] = get_completed_number_of_lesson($user_id, 'course', $course->id);

                    $my_courses[] = $course_details;
                }
            }

            return $my_courses;
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // My Courses API
    public function my_wishlist(Request $request)
    {
        $token = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user_id   = auth('sanctum')->user()->id;
            $wishlist  = Wishlist::where('user_id', $user_id)->pluck('course_id');
            $wishlists = json_decode($wishlist);

            if (sizeof($wishlists) > 0) {
                $courses  = Course::whereIn('id', $wishlists)->get();
                $response = course_data($courses);
            } else {
                $response = [];
            }
        } else {
        }

        return $response;
    }

    // Remove from wishlist
    public function toggle_wishlist_items(Request $request)
    {
        $token = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user_id = auth('sanctum')->user()->id;

            $status       = "";
            $course_id    = $request->course_id;
            $wishlists    = [];
            $check_status = Wishlist::where('course_id', $course_id)->where('user_id', $user_id)->first();
            if (empty($check_status)) {
                $wishlist            = new Wishlist();
                $wishlist->course_id = $request->course_id;
                $wishlist->user_id   = $user_id;
                $wishlist->save();
                $status = "added";
            } else {
                Wishlist::where('user_id', $user_id)->where('course_id', $request->course_id)->delete();
                $status = "removed";
            }
            // $this->my_wishlist($user_id);
            $response['status'] = $status;
            return $response;
        } else {
            return response()->json([
                'message' => 'Please login first',
            ], 400);
        }
    }

    // Get all the sections
    public function sections(Request $request)
    {

        $token = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user_id   = auth('sanctum')->user()->id;
            $course_id = $request->course_id;
            $response  = sections($course_id, $user_id);
        } else {
        }

        return $response;
    }

    // password reset
    public function update_password(Request $request)
    {

        $token    = $request->bearerToken();
        $response = [];

        if (isset($token) && $token != '') {
            $auth = auth('sanctum')->user();

            // The passwords matches
            if (! Hash::check($request->get('current_password'), $auth->password)) {
                $response['status']  = 'failed';
                $response['message'] = 'Current Password is Invalid';

                return $response;
            }

            // Current password and new password same
            if (strcmp($request->get('current_password'), $request->new_password) == 0) {
                $response['status']  = 'failed';
                $response['message'] = 'New Password cannot be same as your current password.';

                return $response;
            }

            // Current password and new password same
            if (strcmp($request->get('confirm_password'), $request->new_password) != 0) {
                $response['status']  = 'failed';
                $response['message'] = 'New Password is not same as your confirm password.';

                return $response;
            }

            $user           = User::find($auth->id);
            $user->password = Hash::make($request->new_password);
            $user->save();

            $response['status']  = 'success';
            $response['message'] = 'Password Changed Successfully';

            return $response;
        } else {
            $response['status']  = 'failed';
            $response['message'] = 'Please login first';

            return $response;
        }
    }

    public function account_disable(Request $request)
    {

        $token    = $request->bearerToken();
        $response = [];

        if (isset($token) && $token != '') {
            $auth = auth('sanctum')->user();

            $account_password = $request->get('account_password');

            // The passwords matches
            if (Hash::check($account_password, $auth->password)) {
                User::where('id', $auth->id)->update([
                    'status' => 0,
                ]);
                $response['validity'] = 1;
                $response['message']  = 'Account has been removed';
            } else {
                $response['validity'] = 0;
                $response['message']  = 'Mismatch password';
            }
        }

        return $response;
    }

    public function cart_list(Request $request)
    {
        $token      = $request->bearerToken();
        $cart_items = [];

        if (isset($token) && $token != '') {
            $auth           = auth('sanctum')->user();
            $my_courses_ids = CartItem::where('user_id', $auth->id)->get();

            foreach ($my_courses_ids as $my_courses_id) {
                $course_details = Course::find($my_courses_id['course_id']);
                array_push($cart_items, $course_details);
            }

            $cart_items = course_data($cart_items);
        }

        return $cart_items;
    }

    // Toggle from cart list
    public function toggle_cart_items(Request $request)
    {
        $token = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user_id = auth('sanctum')->user()->id;

            $status       = "";
            $course_id    = $request->course_id;
            $cart_items   = [];
            $check_status = CartItem::where('course_id', $course_id)->where('user_id', $user_id)->first();
            if (empty($check_status)) {
                $cart_item            = new CartItem();
                $cart_item->course_id = $request->course_id;
                $cart_item->user_id   = $user_id;
                $cart_item->save();
                $status = "added";
            } else {
                CartItem::where('user_id', $user_id)->where('course_id', $request->course_id)->delete();
                $status = "removed";
            }
            // $this->my_wishlist($user_id);
            $response['status'] = $status;
            return $response;
        }
    }

    public function save_course_progress(Request $request)
    {
        $token = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user_id = auth('sanctum')->user()->id;

            $lessons = get_lessons('lesson', $request->lesson_id);

            update_watch_history_manually($request->lesson_id, $lessons[0]->course_id, $user_id);

            return course_completion_data($lessons[0]->course_id, $user_id);
        }
    }

    public function live_class_schedules(Request $request)
    {
        $response = [];

        $classes = [];

        $live_classes = Live_class::where('course_id', $request->course_id)->orderBy('class_date_and_time', 'desc')->get();

        foreach ($live_classes as $key => $live_class) {
            $additional_info = json_decode($live_class->additional_info, true);

            $classes[$key]['class_topic']         = $live_class->class_topic;
            $classes[$key]['provider']            = $live_class->provider;
            $classes[$key]['note']                = $live_class->note;
            $classes[$key]['class_date_and_time'] = $live_class->class_date_and_time;
            $classes[$key]['meeting_id']          = $additional_info['id'];
            $classes[$key]['meeting_password']    = $additional_info['password'];
            $classes[$key]['start_url']           = $additional_info['start_url'];
            $classes[$key]['join_url']            = $additional_info['join_url'];
        }

        $response['live_classes'] = $classes;

        $response['zoom_sdk']               = get_settings('zoom_web_sdk');
        $response['zoom_sdk_client_id']     = get_settings('zoom_sdk_client_id');
        $response['zoom_sdk_client_secret'] = get_settings('zoom_sdk_client_secret');

        return $response;
    }

    public function payment(Request $request)
    {
        $response = [];
        $token    = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user = auth('sanctum')->user();
            Auth::login($user);
        }

        if ($request->app_url) {
            session(['app_url' => $request->app_url . '://']);
        }

        return redirect(route('payment'));
        // return $response;
    }
    public function free_course_enroll(Request $request, $course_id)
    {
        $response = [];
        $token    = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user_id = auth('sanctum')->user()->id;
            $check   = Enrollment::where('course_id', $course_id)->where('user_id', $user_id)->count();
            if ($check == 0) {
                $enrollment['user_id']         = auth('sanctum')->user()->id;
                $enrollment['course_id']       = $course_id;
                $enrollment['enrollment_type'] = 'free';
                $enrollment['entry_date']      = time();
                $enrollment['expiry_date']     = null;
                $done                          = Enrollment::insert($enrollment);
                if ($done) {
                    $response['status']  = true;
                    $response['message'] = "Course Successfully enrolled";
                } else {
                    $response['status']  = false;
                    $response['message'] = "Some error occur,Try again";
                }
            }
        } else {
            $response['status']  = false;
            $response['message'] = "Undefined authentication";
        }

        return $response;
    }
    public function cart_tools(Request $request)
    {
        $response = [];
        $token    = $request->bearerToken();

        if (isset($token) && $token != '') {
            $response['course_selling_tax'] = get_settings('course_selling_tax');
            $response['currency_position']  = get_settings('currency_position');
            $response['currency_symbol']    = DB::table('currencies')->where('code', get_settings('system_currency'))->value('symbol');
        } else {
            $response['status'] = "Not Authorized Credential";
        }
        return $response;
    }

    // my_code

    public function top_bootcamps(Request $request)
    {
        $query = Bootcamp::orderBy('id', 'desc')->get();

        $result = bootcamp_details($query);

        return $result;
    }
    public function bootcamp_details_by_id(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'bootcamp_id' => 'required|exists:bootcamps,id',
            ]);

            $bootcamp_id = $request->bootcamp_id;
            $bootcamp    = Bootcamp::find($bootcamp_id);

            // Fetch modules
            $modules = BootcampModule::where('bootcamp_id', $bootcamp->id)->get();

            foreach ($modules as $module) {
                // Select only required fields from live classes
                $module->live_classes = BootcampLiveClass::select('id', 'module_id', 'title', 'slug')
                    ->where('module_id', $module->id)
                    ->get();

                $module->resource = BootcampResource::where('module_id', $module->id)->get();

                foreach ($module->resource as $resource) {
                    $resource->file = url('public/' . $resource->file);
                }
            }

            $bootcamp->modules      = $modules;
            $bootcamp->faqs         = json_decode($bootcamp->faqs, true);
            $bootcamp->publish_date = date('d-M-Y', $bootcamp->publish_date);
            $bootcamp->live_class   = count_bootcamp_classes($bootcamp->id);
            $bootcamp->thumbnail    = url('public/' . $bootcamp->thumbnail);

            return response()->json($bootcamp);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 200);
        }
    }

    // Bootcamp Purchase
    public function purchase_bootcamp(Request $request, $bootcamp_id)
    {
        $response = [];
        $token    = $request->bearerToken();

        if (isset($token) && $token != '') {
            $user = auth('sanctum')->user();
            Auth::login($user);
        }

        if ($request->app_url) {
            session(['app_url' => $request->app_url . '://']);
        }

        return redirect(route('purchase.bootcamp', ['id' => $bootcamp_id]));
        // return $response;
    }

    public function support_ticket(Request $request)
    {
        $user = auth('sanctum')->user();

        if (! $user) {
            return response()->json([
                'code'    => 401,
                'message' => 'Unauthorized',
            ]);
        }

        $tickets = Ticket::with(['status', 'priority', 'category'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $formatted = $tickets->map(function ($ticket) {
            return [
                'id'         => $ticket->id,
                'subject'    => $ticket->subject,
                'code'       => $ticket->code,
                'status'     => $ticket->status->title ?? null,
                'priority'   => $ticket->priority->title ?? null,
                'category'   => $ticket->category->title ?? null,
                'created_at' => $ticket->created_at?->format('Y-m-d h:i A'),
            ];
        });

        return response()->json([
            'code'    => 200,
            'message' => 'Tickets fetched successfully',
            'data'    => $formatted,
        ]);
    }

    public function support_ticket_store(Request $request)
    {
        $user = auth('sanctum')->user();

        if (! $user) {
            return response()->json([
                'code'    => 401,
                'message' => 'Unauthorized',
            ]);
        }

        // Validation
        $request->validate([
            'subject'     => 'required|string|max:255',
            'status_id'   => 'required|integer',
            'priority_id' => 'required|integer',
            'category_id' => 'required|integer',
            'message'     => 'required|string',
            'file.*'      => 'nullable|file',
        ]);

        $adminId = $user->role == 'admin'
            ? $user->id
            : User::where('role', 'admin')->orderBy('id', 'asc')->value('id');

        // Create Ticket
        $ticket = Ticket::create([
            'subject'     => $request->subject,
            'code'        => random_int(1000, 9999),
            'creator_id'  => $adminId,
            'user_id'     => $user->id,
            'status_id'   => $request->status_id,
            'priority_id' => $request->priority_id,
            'category_id' => $request->category_id,
        ]);

        $paths = [];
        if ($request->hasFile('file')) {

            $files = $request->file('file');
            if (! is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {

                if (! $file || ! $file->isValid()) {
                    continue;
                }

                $fileName        = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/ticket_files');

                if (! file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $fileName);

                $paths[] = 'uploads/ticket_files/' . $fileName;
            }
        }

        // Create First Message
        TicketMessage::create([
            'ticket_thread_code' => $ticket->code,
            'message'            => $request->message,
            'sender_id'          => $user->id,
            'receiver_id'        => $adminId,
            'file'               => ! empty($paths) ? json_encode($paths) : null,
        ]);

        return response()->json([
            'code'    => 200,
            'message' => 'Ticket created successfully',
            'data'    => [
                'ticket_id'   => $ticket->id,
                'ticket_code' => $ticket->code,
            ],
        ]);
    }

    public function support_ticket_message($code = '')
    {
        $user = auth('sanctum')->user();

        if (! $user) {
            return response()->json([
                'code'    => 401,
                'message' => 'Unauthorized',
            ]);
        }

        $ticket = Ticket::with(['status', 'priority', 'category'])
            ->where('code', $code)
            ->first();

        if (! $ticket) {
            return response()->json([
                'code'    => 404,
                'message' => 'Ticket not found',
            ]);
        }

        $conversations = TicketMessage::where('ticket_thread_code', $code)->get();

        // Single Object Format
        $formatted_details = [
            'id'         => $ticket->id,
            'subject'    => $ticket->subject,
            'code'       => $ticket->code,
            'status'     => $ticket->status->title ?? null,
            'priority'   => $ticket->priority->title ?? null,
            'category'   => $ticket->category->title ?? null,
            'created_at' => $ticket->created_at?->format('Y-m-d h:i A'),
        ];

        // Conversation Collection
        $formatted_conversation = $conversations->map(function ($conversation) {

            $files = $conversation->file ? json_decode($conversation->file, true) : [];

            // full url (important)
            $files = collect($files)->map(function ($path) {
                return asset($path);
            });

            return [
                'id'         => $conversation->id,
                'message'    => $conversation->message,
                'sender_id'  => $conversation->sender_id,
                'file'       => $files,
                'created_at' => $conversation->created_at?->format('Y-m-d h:i A'),
            ];
        });

        return response()->json([
            'code'           => 200,
            'message'        => 'Message fetched successfully',
            'ticket_details' => $formatted_details,
            'conversation'   => $formatted_conversation,
        ]);
    }

    public function support_ticket_message_store(Request $request)
    {
        $user = auth('sanctum')->user();

        if (! $user) {
            return response()->json([
                'code'    => 401,
                'message' => 'Unauthorized',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'ticket_thread_code' => 'required',
            'message'            => $request->hasFile('file') ? 'nullable|string' : 'required|string',
            'file'               => 'nullable|array',
            'file.*'             => 'file',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'    => 422,
                'message' => $validator->errors()->first(),
            ]);
        }

        $ticket = Ticket::where('code', $request->ticket_thread_code)->first();

        if (! $ticket) {
            return response()->json([
                'code'    => 404,
                'message' => 'Ticket not found',
            ]);
        }

        // Receiver auto detect
        $receiverId = $user->id == $ticket->user_id ? $ticket->creator_id : $ticket->user_id;

        $paths = [];
        if ($request->hasFile('file')) {

            $files = $request->file('file');
            if (! is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {

                if (! $file || ! $file->isValid()) {
                    continue;
                }

                $fileName        = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/ticket_files');

                if (! file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $fileName);

                $paths[] = 'uploads/ticket_files/' . $fileName;
            }
        }

        // Insert Message
        $message = TicketMessage::create([
            'ticket_thread_code' => $ticket->code,
            'message'            => $request->message,
            'sender_id'          => $user->id,
            'receiver_id'        => $receiverId,
            'file'               => ! empty($paths) ? json_encode($paths) : null,
        ]);

        return response()->json([
            'code'    => 200,
            'message' => 'Message sent successfully',
            'data'    => [
                'id'          => $message->id,
                'ticket_code' => $ticket->code,
                'message'     => $message->message,
                'file'        => $paths,
                'created_at'  => $message->created_at?->format('Y-m-d h:i A'),
            ],
        ]);
    }

    public function ticket_categories()
    {
        $categories = TicketCategory::where('status', 1)->get();

        $formatted = $categories->map(function ($category) {
            return [
                'id'    => $category->id,
                'title' => $category->title,
            ];
        });

        return response()->json([
            'code'    => 200,
            'message' => 'Categories fetched successfully',
            'data'    => $formatted,
        ]);
    }

    public function ticket_status()
    {
        $statuses = TicketStatus::where('status', 1)->get();

        $formatted = $statuses->map(function ($status) {
            return [
                'id'    => $status->id,
                'title' => $status->title,
            ];
        });

        return response()->json([
            'code'    => 200,
            'message' => 'Status fetched successfully',
            'data'    => $formatted,
        ]);
    }

    public function ticket_priorities()
    {
        $priorities = TicketPriority::where('status', 1)->get();

        $formatted = $priorities->map(function ($priority) {
            return [
                'id'    => $priority->id,
                'title' => $priority->title,
            ];
        });

        return response()->json([
            'code'    => 200,
            'message' => 'Priority fetched successfully',
            'data'    => $formatted,
        ]);
    }

    public function purchase_history(Request $request)
    {
        $user = auth('sanctum')->user();

        if (! $user) {
            return response()->json([
                'code'    => 401,
                'message' => 'Unauthorized',
            ], 401);
        }

        $currency = DB::table('currencies')->where('code', get_settings('system_currency'))->value('symbol');

        $payments_raw = Payment_history::where('user_id', $user->id)
            ->latest('id')
            ->get();

        $payments = $payments_raw->map(function ($payment) use ($currency) {

            $course_title = DB::table('courses')->where('id', $payment->course_id)->value('title');
            $user_name    = DB::table('users')->where('id', $payment->user_id)->value('name');

            $created_date = $payment->created_at ? $payment->created_at->format('Y-m-d') : null;

            return [
                'id'           => $payment->id,
                'amount'       => $payment->amount,
                'payment_type' => $payment->payment_type,
                'created_at'   => $created_date,
                'course_title' => $course_title ?? '',
                'user_name'    => $user_name ?? '',
                'currency'     => $currency,
            ];
        });

        return response()->json([
            'code'    => 200,
            'message' => 'Purchase history fetched successfully',
            'data'    => $payments,
        ], 200);
    }

    public function message()
    {
        $authUser = auth('sanctum')->user();

        if (! $authUser) {
            return response()->json([
                'code'    => 401,
                'message' => 'Unauthorized',
            ], 401);
        }

        $threads = MessageThread::where(function ($q) use ($authUser) {
            $q->where('contact_one', $authUser->id)
                ->orWhere('contact_two', $authUser->id);
        })->with('messages')->orderBy('updated_at', 'desc')->get();

        $data = [];

        foreach ($threads as $thread) {

            // manually other user
            $otherUserId = $thread->contact_one == $authUser->id
                ? $thread->contact_two
                : $thread->contact_one;

            $otherUser = User::find($otherUserId);

            $last_message = $thread->messages()->orderBy('id', 'desc')->first();

            $data[] = [
                'thread_code'     => $thread->code,
                'user_id'         => $otherUser?->id,
                'name'            => $otherUser?->name,
                'photo'           => $otherUser && $otherUser->photo
                    ? get_image($otherUser->photo)
                    : null,
                'last_message'    => $last_message?->message,
                'last_message_at' => $last_message?->created_at,
            ];
        }

        return response()->json([
            'code'    => 200,
            'threads' => $data,
        ]);
    }

}
