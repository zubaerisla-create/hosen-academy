@php
$type = request()->get('type');
@endphp
<form class="required-form" action="{{ route('admin.gamification.badges.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}<span class="required">*</span></label>
        <input type="text" name = "title" id = "title" class="form-control ol-form-control" required>
    </div>
  
    <div class="fpb-7 mb-3">
            <label class="form-label fw-semibold">
                {{ get_phrase('Condition') }} <span class="text-danger">*</span>
            </label>

            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">{{ get_phrase('From') }}</span>
                        <input type="number" name="condition_from"   class="form-control ol-form-control"  placeholder="0"  min="0"  required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">{{ get_phrase('To') }}</span>
                        <input type="number" name="condition_to"  class="form-control ol-form-control"  placeholder="10"  min="0" required>
                        <span class="input-group-text bg-light">{{ get_phrase('Courses') }}</span>
                    </div>
                </div>
            </div>
        </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="description">{{ get_phrase('Description') }}<span class="required">*</span></label>
        <textarea name="description" id="description" class="form-control ol-form-control" rows="5" required></textarea>
    </div>
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="image">{{ get_phrase('Image'); }}<span class="required">*</span></label>
        <input type="file" name = "image" id = "image" class="form-control ol-form-control" required>
    </div>       
    <div class="row">
        <div class="col-md-8">
            <button type="submit" class="ol-btn-primary" >{{ get_phrase('Create') }}</button>
        </div>
    </div>
</form>
