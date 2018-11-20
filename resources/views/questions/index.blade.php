@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <div class="d-flex aling-items-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.create') }}" class="btn btn-outline-secondary">Create questions</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary">
                        @include('layouts._messages')
                        @foreach($questions as $question)
                            <div class="media">

                                <div class="d-flex flex-column counters">
                                    <div class="vote">
                                        <strong>{{ $question->votes_count }}</strong>{{ str_plural('vote', $question->votes_count) }}
                                    </div>
                                    <div class="status {{ $question->status }}">
                                        <strong>{{ $question->answers_count }}</strong>{{ str_plural('answer', $question->answers_count) }}
                                    </div>
                                    <div class="view">
                                        {{ $question->views . " " . str_plural('view', $question->views )}}
                                    </div>
                                </div>

                                <div class="media-body text-warning">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{ $question->url  }}" class="text-success">{{ $question->title }}</a></h3>
                                        <div class="ml-auto d-flex">
                                            @can('update-question', $question) <!-- or add if(Auth::user()->can() endif-->
                                                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan

                                            @can('delete-question', $question)
                                                <form class="pl-1" method="post" action="{{ route('questions.destroy', $question->id) }}">
                                                    @method('DELETE') <!-- method_field('DELETE') -->
                                                    @csrf {{-- csrf_token() --}}
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p class="lead text-info">
                                        Asked by
                                        <a href="{{ $question->user->url }}" class="text-info">{{ $question->user->name }}</a>
                                        <small>{{ $question->created_date }}</small>
                                    </p>
                                    {{ str_limit($question->body, 250) }}
                                    <hr>
                                </div>

                            </div>
                        @endforeach

                            {{ $questions->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
