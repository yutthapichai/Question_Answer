@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex aling-items-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all questions</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('questions.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="question-title">Question Title</label>
                                <input value="{{ old('title') }}" type="text" name="title" id="question-title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                            @if($errors->has('title'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                            </div>
                            <div class="form-group">
                                <label for="question-body">Question Body</label>
                                <textarea type="text" name="body" id="question-body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" rows="10">
                                    {{ old('body') }}
                                </textarea>
                            @if($errors->has('body'))
                                <span class="invalid-feedback">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                            @endif
                            </div>
                            <div class="form-group">
                                <button class="btn btn-outline-primary btn-lg" type="submit">Ask this question</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
