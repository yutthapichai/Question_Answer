@csrf
<div class="form-group">
    <label for="question-title">Question Title</label>
    <input value="{{ old('title', $question->title) }}" type="text" name="title" id="question-title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
    @if($errors->has('title'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <label for="question-body">Question Body</label>
    <textarea type="text" name="body" id="question-body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" rows="10">
        {{ old('body', $question->body) }}
    </textarea>
    @if($errors->has('body'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('body') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <button class="btn btn-outline-primary btn-lg" type="submit">{{ $buttonText }}</button>
</div>