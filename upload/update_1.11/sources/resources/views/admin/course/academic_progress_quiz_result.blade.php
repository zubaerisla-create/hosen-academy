@php

    $course_id = request()->get('course_id');

    $course_details = App\Models\Course::find($course_id);

    $quizes = App\Models\Lesson::where('course_id', $course_details->id)
        ->where('lesson_type', 'quiz')
        ->get();

@endphp
<style>
    .eProgress:last-child{
        border-bottom: none !important;
    }
</style>

<div class="row">

    @foreach ($quizes as $key => $quiz)
        <div class="col-md-12 border-bottom eProgress pb-3 mb-3">

            <p class="mb-1 fw-bold">

                <b>Q{{ $key + 1 }}.</b>

                <span class="float-end">
                    {{ get_phrase('Total Marks') }} :
                    <b>{{ $quiz->total_mark ?? 0 }}</b>
                </span>

            </p>

            <p>{{ $quiz->title }}</p>


            @php

                $quiz_results = App\Models\QuizSubmission::where('quiz_id', $quiz->id)
                    ->where('user_id', $student_id)
                    ->orderBy('id', 'asc')
                    ->get();

            @endphp


            <p class="my-0">
                {{ get_phrase('Total attempts') }} : {{ $quiz_results->count() }}
            </p>


            <p class="my-0">

                {{ get_phrase('Obtained Marks of all attempts') }} :

                @if ($quiz_results->count() > 0)

                    @foreach ($quiz_results as $result)

                        @php

                            $correct_answers = json_decode($result->correct_answer, true);
                            $wrong_answers   = json_decode($result->wrong_answer, true);

                            $correct_count = is_array($correct_answers) ? count($correct_answers) : 0;
                            $wrong_count   = is_array($wrong_answers) ? count($wrong_answers) : 0;

                            $total_question = $correct_count + $wrong_count;

                            $total_mark = $quiz->total_mark ?? 0;

                            $obtained_mark = 0;

                            if ($total_question > 0) {
                                $obtained_mark = ($correct_count / $total_question) * $total_mark;
                            }

                        @endphp

                        {{ number_format($obtained_mark, 2) }}

                        @if (!$loop->last)
                            ,
                        @endif

                    @endforeach

                @else
                    0
                @endif

            </p>

        </div>
    @endforeach

</div>