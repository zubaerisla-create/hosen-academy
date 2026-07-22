<style>
    .question {
        min-height: auto !important;
    }

    .accordion-button::after {
        background-size: 14px;
    }

    .accordion-button:focus {
        box-shadow: none
    }

    .accordion-button:not(.collapsed) {
        background: #f4f7fe;
    }
</style>
<div class="accordion" id="accordionExample">
    @foreach ($results as $key => $result)
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed fs-14px fw-500" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse-{{ $result->id }}" aria-expanded="false"
                aria-controls="collapse-{{ $result->id }}">
                {{ get_phrase('Attempt ') }}{{ ++$key }}
                <span class="ms-5">{{ date('d M, Y H:i', strtotime($result->created_at)) }}</span>
            </button>
        </h2>

        <div id="collapse-{{ $result->id }}" class="accordion-collapse collapse"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="result">

                    @php
                        $submits = $result->submits ? json_decode($result->submits, true) : [];
                        $correct_answers = $result->correct_answer ? json_decode($result->correct_answer, true) : [];
                        $wrong_answers = $result->wrong_answer ? json_decode($result->wrong_answer, true) : [];
                        $mark_per_question = $quiz->total_mark / $questions->count();
                    @endphp

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p>{{ get_phrase('Duration : ') }}
                                @php $duration = explode(':', $quiz->duration); @endphp
                                {{ $duration[0] }} {{ get_phrase('Hour') }}
                                {{ $duration[1] }} {{ get_phrase('Minute') }}
                                {{ $duration[2] ?? '00' }} {{ get_phrase('Second') }} {{--  MODIFIED --}}
                            </p>
                            <p>{{ get_phrase('Total Mark : ') }}{{ $quiz->total_mark }}</p>
                            <p>{{ get_phrase('Pass Mark : ') }}{{ $quiz->pass_mark }}</p>
                        </div>

                        <div class="col-md-6">
                            <p>{{ get_phrase('Correct Answer : ') }}{{ count($correct_answers) }}</p>
                            <p>{{ get_phrase('Wrong Answer : ') }}{{ count($wrong_answers) }}</p>
                            <p>{{ get_phrase('Obtained marks') }} :
                                {{ number_format(count($correct_answers) * $mark_per_question, 2) }}
                            </p>

                            <p>{{ get_phrase('Result : ') }}
                                @if (count($correct_answers) * $mark_per_question >= $quiz->pass_mark)
                                    <span class="text-success">{{ get_phrase('Passed') }}</span>
                                @else
                                    <span class="text-danger">{{ get_phrase('Failed') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @foreach ($questions as $key => $question)

                        @php
                            $decoded_answer = json_decode($question->answer, true); //  ADDED

                            $given_answer =
                                $question->type == 'true_false'
                                    ? $question->answer
                                    : (is_array($decoded_answer)
                                        ? implode(', ', $decoded_answer)
                                        : $decoded_answer); //  MODIFIED SAFE

                                    //  ADDED (single_choice correct answer fix)
                                    if ($question->type == 'single_choice') {
                                        $given_answer = is_array($decoded_answer)
                                            ? ($decoded_answer[0] ?? '')
                                            : $question->answer;
                                    }

                                    $user_answers = array_key_exists($question->id, $submits)
                                        ? $submits[$question->id]
                                        : [];

                                    //  ADDED normalize user answer
                                    $user_val = is_array($user_answers)
                                        ? ($user_answers[0] ?? '')
                                        : $user_answers;

                                    $user_val = is_string($user_val)
                                        ? strtolower(trim($user_val))
                                        : '';
                        @endphp


                        <div class="result-question mb-4">
                            <div class="mb-1 d-flex align-items-center gap-3">
                                <span class="serial">{{ ++$key }}</span>
                                <div>{!! $question->title !!}</div>

                                @if (in_array($question->id, $correct_answers))
                                    <i class="fi fi-br-check text-success"></i>
                                @elseif(in_array($question->id, $wrong_answers))
                                    <i class="fi fi-br-cross-small text-danger"></i>
                                @endif
                            </div>


                            <div class="row {{ $question->type == 'fill_blanks' ? 'px-2' : '' }}">

                                {{-- MCQ --}}
                                @if ($question->type == 'mcq')
                                    @php $options = json_decode($question->options, true) ?? []; @endphp

                                    @foreach ($options as $index => $option)
                                        @php
                                            $val = $user_answers
                                                ? array_search($option, $user_answers)
                                                : '';
                                        @endphp

                                        <div class="col-sm-6">
                                            <input class="form-check-input"
                                                type="checkbox"
                                                value="{{ $option }}"
                                                @if (is_numeric($val)) checked @endif
                                                disabled>

                                            <label class="form-check-label text-capitalize">
                                                {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach


                                {{-- FILL BLANKS --}}
                                @elseif($question->type == 'fill_blanks')

                                    <input type="text"
                                        class="form-control tagify"
                                        data-role="tagsinput"
                                        value="{{ json_encode($user_answers) }}"
                                        disabled>


                                {{-- TRUE FALSE --}}
                                @elseif($question->type == 'true_false')

                                    <div class="col-sm-2">
                                        <input class="form-check-input"
                                            type="radio"
                                            disabled
                                            @if ($user_val == 'true') checked @endif> {{--  MODIFIED --}}
                                        <label class="form-check-label">
                                            {{ get_phrase('True') }}
                                        </label>
                                    </div>

                                    <div class="col-sm-2">
                                        <input class="form-check-input"
                                            type="radio"
                                            disabled
                                            @if ($user_val == 'false') checked @endif> {{--  MODIFIED --}}
                                        <label class="form-check-label">
                                            {{ get_phrase('False') }}
                                        </label>
                                    </div>


                                {{-- ADDED SINGLE CHOICE --}}
                                @elseif($question->type == 'single_choice')

                                    @php
                                        $options = json_decode($question->options, true) ?? [];
                                    @endphp

                                    @foreach ($options as $index => $option)

                                        <div class="col-sm-6">

                                            <input class="form-check-input"
                                                type="radio"
                                                disabled
                                                value="{{ $option }}"
                                                @if ($user_val == strtolower(trim($option))) checked @endif>

                                            <label class="form-check-label text-capitalize">
                                                {{ $option }}
                                            </label>

                                        </div>

                                    @endforeach
                                {{--  END ADDED --}}

                                @endif


                                <p class="text-capitalize text-success fw-600">
                                    {{ get_phrase('Answer : ') }} {{ $given_answer }}
                                </p>

                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
    $('.result .tagify:not(.inited)').each(function(index, element) {
        var tagify = new Tagify(element, {
            placeholder: '{{ get_phrase('Enter your keywords') }}'
        });
        $(element).addClass('inited');
    });
</script>
