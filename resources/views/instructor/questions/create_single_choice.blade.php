{{-- Number of Options --}}
<div class="fpb7 mb-3">
    <label for="optionCount" class="form-label ol-form-label">
        {{ get_phrase('Options') }}
    </label>

    <input 
        type="number"
        id="optionCount"
        name="option_count"
        class="form-control ol-form-control"
        min="1"
        max="10"
        value="1"
    />
</div>

{{-- Dynamic Option Inputs + Radio Buttons --}}
<div class="fpb7 mb-3">
    <label class="form-label ol-form-label">
        {{ get_phrase('Answer') }}
        <span class="text-danger ms-1">*</span>
    </label>

    <div>
        <div id="optionsGroup" class="d-flex flex-column gap-2">
            <!-- Dynamic options injected here -->
        </div>
    </div>
</div>

<script>

function initSingleChoiceOptions(){

    const optionCountInput = document.getElementById('optionCount');
    const optionsGroup = document.getElementById('optionsGroup');

    if(!optionCountInput || !optionsGroup){
        return;
    }

    function renderOptions(count){

        optionsGroup.innerHTML = '';

        for(let i = 0; i < count; i++){

            const div = document.createElement('div');
            div.className = 'input-group mb-2';

            // option text
            const inputText = document.createElement('input');
            inputText.type = 'text';
            inputText.name = 'options[]';
            inputText.className = 'form-control ol-form-control';
            inputText.placeholder = 'Option ' + (i + 1);
            inputText.required = true;

            // radio container
            const span = document.createElement('span');
            span.className = 'input-group-text';

            // radio button
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
    }

    // initial load
    let startCount = parseInt(optionCountInput.value);

    if(isNaN(startCount) || startCount < 1){
        startCount = 1;
    }

    renderOptions(startCount);

    // change option count
    optionCountInput.addEventListener('input', function(){

        let val = parseInt(this.value);

        if(isNaN(val) || val < 1){
            val = 1;
        }

        if(val > 10){
            val = 10;
        }

        renderOptions(val);
    });

}

// run after load
initSingleChoiceOptions();

</script>