<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuizSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
  public function quiz_submit(Request $request)
    {
        $lesson = Lesson::where('id', $request->quiz_id)->firstOrFail();
        $retake = $lesson->retake;
        $submit = QuizSubmission::where('quiz_id', $request->quiz_id)->where('user_id', auth()->user()->id)->count();
        if ($submit > $retake) {
            Session::flash('warning', get_phrase('Attempt has been over.'));
            echo '<script>
            window.location.href = "'.route('course.player', ['slug' => $lesson->course->slug, 'id' => $lesson->id ?? '']).'"
            </script>';
            die();
        }

        $inputs  = collect($request->all());
        $quiz_id = $inputs->pull('quiz_id');
        $inputs->forget(['_token', 'quiz_id']);

        $submits = $inputs->whereNotNull();
        // foreach ($submits as $key => $submit) {
        //     if (is_string($submit) && ($submit != 'true' && $submit != 'false')) {
        //         $submits[$key] = array_column(json_decode($submit), 'value');
        //     }
        // }


            foreach ($submits as $key => $submit) {
                // MCQ (array type) only
                if (is_string($submit) && ($submit != 'true' && $submit != 'false')) {
                    $decoded = json_decode($submit, true);
                    if (is_array($decoded)) {
                        $submits[$key] = array_column($decoded, 'value');
                    }
                    // Otherwise leave $submit as-is (for single_choice / fill_blanks)
                }
            }


        $question_ids      = $submits->keys();
        $submitted_answers = $submits->values();
        $questions         = Question::whereIn('id', $question_ids)->get();

        $right_answers = $wrong_answers = [];
        // foreach ($questions as $key => $question) {

        //     $correct_answer = json_decode($question->answer, true);
        //     $submitted      = $submitted_answers[$key];

        //     if ($question->type == 'mcq') {
        //         $isCorrect = empty(array_diff($correct_answer, $submitted)) && empty(array_diff($submitted, $correct_answer));
        //     } elseif ($question->type == 'fill_blanks') {
        //         $isCorrect = count($correct_answer) === count($submitted);

        //         if ($isCorrect) {
        //             for ($i = 0; $i < count($correct_answer); $i++) {
        //                 if (strtolower($correct_answer[$i]) != strtolower($submitted[$i])) {
        //                     $isCorrect = false;
        //                     break;
        //                 }
        //             }
        //         } else {
        //             $isCorrect = false;
        //         }
        //     } elseif ($question->type == 'true_false') {
        //         $isCorrect = strtolower(json_encode($correct_answer)) == strtolower($submitted);
        //     }elseif($question->type == 'single_choice'){
        //           $isCorrect = trim($submitted) === trim($correct_answer);
        //     }

        //     $isCorrect ? $right_answers[] = $question->id : $wrong_answers[] = $question->id;
        // }
        foreach ($questions as $key => $question) {

            $correct_answer = json_decode($question->answer, true);
            $submitted      = $submitted_answers[$key];

            if ($question->type == 'mcq') {
                $isCorrect = empty(array_diff($correct_answer, $submitted)) && empty(array_diff($submitted, $correct_answer));
            } elseif ($question->type == 'fill_blanks') {
                $isCorrect = count($correct_answer) === count($submitted);
                if ($isCorrect) {
                    for ($i = 0; $i < count($correct_answer); $i++) {
                        if (strtolower($correct_answer[$i]) != strtolower($submitted[$i])) {
                            $isCorrect = false;
                            break;
                        }
                    }
                }
            } elseif ($question->type == 'true_false') {
                // $isCorrect = strtolower(json_encode($correct_answer)) == strtolower($submitted);
                 //  convert first element to string
                $submitted = is_array($submitted) ? $submitted[0] : $submitted;
                $submitted = strtolower(trim($submitted));

                $correct_answer = is_array(json_decode($question->answer, true)) ? json_decode($question->answer, true)[0] : $question->answer;
                $correct_answer = strtolower(trim($correct_answer));

                $isCorrect = $submitted === $correct_answer;

            } elseif ($question->type == 'single_choice') {
                 $correct_answer = is_array(json_decode($question->answer, true)) ? json_decode($question->answer, true)[0] : $question->answer;
                $submitted = is_array($submitted) ? $submitted[0] : $submitted;

                $isCorrect = trim((string)$submitted) === trim((string)$correct_answer);
            }

            $isCorrect ? $right_answers[] = $question->id : $wrong_answers[] = $question->id;
        }

        $data['quiz_id']        = $quiz_id;
        $data['user_id']        = auth()->user()->id;
        $data['correct_answer'] = $right_answers ? json_encode($right_answers) : null;
        $data['wrong_answer']   = $wrong_answers ? json_encode($wrong_answers) : null;
        $data['submits']        = $submits->count() > 0 ? json_encode($submits->toArray()) : null;

        QuizSubmission::insert($data);
        Session::flash('success', get_phrase('Your answers have been submitted.'));
        echo '<script>
        window.location.href = "'.route('course.player', ['slug' => $lesson->course->slug, 'id' => $lesson->id ?? '']).'"
        </script>';
        die();
    }

    public function load_result(Request $request)
    {
        $page_data['quiz']      = Lesson::where('id', $request->quiz_id)->first();
        $page_data['questions'] = Question::where('quiz_id', $request->quiz_id)->get();
        $page_data['result']    = QuizSubmission::where('id', $request->submit_id)
            ->where('quiz_id', $request->quiz_id)
            ->where('user_id', auth()->user()->id)
            ->first();
        return view('course_player.quiz.result', $page_data);
    }

    public function load_questions(Request $request)
    {
        $page_data['quiz']      = Lesson::where('id', $request->quiz_id)->first();
        $page_data['questions'] = Question::where('quiz_id', $request->quiz_id)->get();
        $page_data['submits']   = QuizSubmission::where('quiz_id', $request->quiz_id)
            ->where('user_id', auth()->user()->id)
            ->get();
        $page_data['course_details'] = Course::where('id', $page_data['quiz']->course_id)->first();
        return view('course_player.quiz.questions', $page_data);
    }
}
