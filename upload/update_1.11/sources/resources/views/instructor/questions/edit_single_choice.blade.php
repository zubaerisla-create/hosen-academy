@php
$options = json_decode($question->options, true);

$answer = $question->answer;
if (is_string($answer)) {
    $decodedAnswer = json_decode($answer, true);
    if (is_array($decodedAnswer)) {
        $answer = $decodedAnswer[0] ?? '';
    } else {
        $answer = $answer;
    }
} else {
    $answer = '';
}
@endphp

<div class="fpb7 mb-3">
    <label for="optionCount" class="form-label ol-form-label">
        {{ get_phrase('Options') }}
    </label>

    <input  type="number"
        id="optionCount"
        name="option_count"
        class="form-control ol-form-control"
        min="1"
        max="10"
        value="{{ count($options) }}"
    />
</div>

<div class="fpb7 mb-3">
    <label class="form-label ol-form-label">
        {{ get_phrase('Answer') }}
        <span class="text-danger ms-1">*</span>
    </label>

    <div>
        <div id="optionsGroup" class="d-flex flex-column gap-2"></div>
    </div>
</div>

<script>
function initSingleChoiceOptions(questionOptions, questionAnswer) {
    const optionCountInput = document.getElementById('optionCount');
    const optionsGroup = document.getElementById('optionsGroup');

    if (!optionCountInput || !optionsGroup) return;

    // question-specific variables
    let existingOptions = [...questionOptions];
    let existingAnswer = questionAnswer;

    function renderOptions(count) {
        optionsGroup.innerHTML = '';

        let currentOptions = [...existingOptions];

        if (currentOptions.length > count) {
            currentOptions = currentOptions.slice(0, count);
        }
        while (currentOptions.length < count) {
            currentOptions.push('');
        }

        for (let i = 0; i < count; i++) {
            const div = document.createElement('div');
            div.className = 'input-group mb-2';

            const inputText = document.createElement('input');
            inputText.type = 'text';
            inputText.name = 'options[]';
            inputText.className = 'form-control ol-form-control';
            inputText.placeholder = 'Option ' + (i + 1);
            inputText.required = true;
            inputText.value = currentOptions[i] ?? '';

            // update existingOptions on input change
            inputText.addEventListener('input', function() {
                existingOptions[i] = this.value;
            });

            const span = document.createElement('span');
            span.className = 'input-group-text';

            const radio = document.createElement('input');
            radio.type = 'radio';
            radio.name = 'answer';
            radio.value = i;
            radio.required = true;

            span.appendChild(radio);
            div.appendChild(inputText);
            div.appendChild(span);
            optionsGroup.appendChild(div);
        }

        // check correct answer
        const radios = optionsGroup.querySelectorAll('input[type="radio"][name="answer"]');
        const checkedIndex = currentOptions.findIndex(opt => opt.trim() === existingAnswer.trim());
        if (checkedIndex !== -1 && radios[checkedIndex]) {
            radios[checkedIndex].checked = true;
        }
    }

    let startCount = parseInt(optionCountInput.value);
    if (isNaN(startCount) || startCount < 1) startCount = 1;

    renderOptions(startCount);

    optionCountInput.addEventListener('input', function () {
        let val = parseInt(this.value);
        if (isNaN(val) || val < 1) val = 1;
        if (val > 10) val = 10;
        renderOptions(val);
    });
}

// Call this function for current question when modal opens
initSingleChoiceOptions(@json($options), @json($answer));
</script>