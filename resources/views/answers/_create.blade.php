<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body bg-secondary">
                <div class="card-title text-light">
                    <h3>Your Answer</h3>
                </div>
                <hr>
                <form action="{{ route('questions.answers.store', $question->id) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="" cols="30" rows="7" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"></textarea>
                        @if($errors->has('body'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="form-group float-right">
                        <button class="btn btn-lg btn-outline-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>