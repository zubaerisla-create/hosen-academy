<style>
    .question {
        min-height: auto !important;
    }
</style>

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
                {{ $duration[1] }} {{ get_phrase('Second') }}
            </p>
            <p>{{ get_phrase('Total Mark : ') }}{{ $quiz->total_mark }}</p>
            <p>{{ get_phrase('Pass Mark : ') }}{{ $quiz->pass_mark }}</p>
        </div>
        <div class="col-md-6">
            <p>{{ get_phrase('Correct Answer : ') }}{{ count($correct_answers) }}</p>
            <p>{{ get_phrase('Wrong Answer : ') }}{{ count($wrong_answers) }}</p>
            <p>{{ get_phrase('Obtained marks') }} :  {{ number_format(count($correct_answers) * $mark_per_question, 2) }}</p>
            <p>{{ get_phrase('Result : ') }}
                @if (count($correct_answers)*$mark_per_question >= $quiz->pass_mark)
                    <span class="text-success">{{ get_phrase('Passed') }}</span>
                @else
                    <span class="text-danger">{{ get_phrase('Failed') }}</span>
                @endif
            </p>
        </div>
    </div>

            @foreach ($questions as $key => $question)
                @php
                    // Correct answer
                    $correct_answer = $question->answer;

                    if ($question->type == 'mcq' || $question->type == 'fill_blanks') {
                        $decoded = json_decode($question->answer, true);
                        $correct_answer = is_array($decoded) ? $decoded : [$decoded];
                    } elseif ($question->type == 'true_false' || $question->type == 'single_choice') {
                        $decoded = json_decode($question->answer, true);
                        $correct_answer = is_array($decoded) ? $decoded[0] : $question->answer;
                        $correct_answer = strtolower(trim($correct_answer));
                    }

                    // Student submitted answer
                    $user_answers = $submits[$question->id] ?? null;
                    if (is_array($user_answers)) {
                        $user_answers = $user_answers[0] ?? null;
                    }
                    $user_answers = is_string($user_answers) ? strtolower(trim($user_answers)) : '';
                @endphp

                <div class="result-question mb-4">
                    <div class="mb-1 d-flex align-items-center gap-3">
                        <span class="serial">{{ ++$key }}</span>
                        <div>{!! $question->title !!}</div>

                        @if (in_array($question->id, $correct_answers ?? []))
                            <i class="fi fi-br-check text-success"></i>
                        @elseif(in_array($question->id, $wrong_answers ?? []))
                            <i class="fi fi-br-cross-small text-danger"></i>
                        @endif
                    </div>

                    <div class="row gap-0">
                        @if ($question->type == 'mcq')
                            @php $options = json_decode($question->options, true) ?? []; @endphp
                            @foreach ($options as $option)
                                @php $checked = in_array($option, $submits[$question->id] ?? []) ? 'checked' : ''; @endphp
                                <div class="col-sm-6">
                                    <input class="form-check-input" type="checkbox" value="{{ $option }}" {{ $checked }} disabled>
                                    <label class="form-check-label text-capitalize">{{ $option }}</label>
                                </div>
                            @endforeach

                        @elseif ($question->type == 'fill_blanks')
                            <input type="text" class="form-control tagify"
                                value="{{ is_array($submits[$question->id] ?? null) ? implode(',', $submits[$question->id]) : ($submits[$question->id] ?? '') }}"
                                disabled>

                        @elseif ($question->type == 'true_false')
                            <div class="col-sm-2">
                                <input class="form-check-input" type="radio" name="{{ $question->id }}" value="true" disabled
                                    @if ($user_answers === 'true') checked @endif>
                                <label class="form-check-label">{{ get_phrase('True') }}</label>
                            </div>
                            <div class="col-sm-2">
                                <input class="form-check-input" type="radio" name="{{ $question->id }}" value="false" disabled
                                    @if ($user_answers === 'false') checked @endif>
                                <label class="form-check-label">{{ get_phrase('False') }}</label>
                            </div>

                        @elseif ($question->type == 'single_choice')
                            @php $options = json_decode($question->options, true) ?? []; @endphp
                            @foreach ($options as $index => $option)
                                <div class="col-sm-6">
                                    <input class="form-check-input" type="radio" name="{{ $question->id }}"
                                        value="{{ $option }}" disabled
                                        @if ($user_answers === strtolower(trim($option))) checked @endif
                                        id="{{ $question->id }}-{{ $index }}">
                                    <label class="form-check-label text-capitalize" for="{{ $question->id }}-{{ $index }}">
                                        {{ $option }}
                                    </label>
                                </div>
                            @endforeach
                        @endif

                        <p class="text-capitalize text-success fw-600 mt-2">
                            {{ get_phrase('Answer : ') }}
                            @if(is_array($correct_answer)) {{ implode(', ', $correct_answer) }} @else {{ $correct_answer }} @endif
                        </p>
                    </div>
                </div>
            @endforeach

    <div class="row">
        <div class="col-12 d-flex gap-3 justify-content-center">
            <button type="button" class="eBtn gradient border-0 mb-4 d-flex align-items-center gap-2" id="backBtn" onclick="back()"><i class="fi fi-rr-angle-small-left fs-5"></i>{{ get_phrase('Back') }}</button>
        </div>
    </div>
</div>

<script>
    // back to main
    function back() {
        description.classList.remove('d-none');
        starterContainer.classList.remove('d-none');
        document.querySelector('.result').remove();
    }

    $('.result .tagify:not(.inited)').each(function(index, element) {
        var tagify = new Tagify(element, {
            placeholder: '{{ get_phrase('Enter your keywords') }}'
        });
        $(element).addClass('inited');
    });
</script>




