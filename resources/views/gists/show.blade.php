@extends('layouts.app')

@section('content')
    <h1>{{ $gist->firstFile()->name }}</h1>
    <div class="row">
        <div class="col-md-9">{{ $gist->description }}</div>
        <div class="col-md-3 text-right"><a href="{{ $gist->gitHubUrl() }}" target="_blank" class="btn btn-default"><i class="fa fa-external-link"></i> View on GitHub</a></div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-3 vote_tallies">
            @if($gist->voteCount() > 0)
                @if($gist->getPositiveVotes()->count() > 0)
                    <div class="alert alert-success">
                        <h2>{{ $gist->getPositiveVotes()->count() }} <small>+1's</small></h2>
                        @foreach($gist->getPositiveVotes()->all() as $voter)
                            <a href="{{ $voter->profile() }}" target="_blank">
                                <img class="avatar img-responsive" src="{{ $voter->avatar() }}" alt="{{ $voter->username() }}">
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($gist->getNegativeVotes()->count() > 0)
                    <div class="alert alert-danger">
                        <h2>{{ $gist->getNegativeVotes()->count() }} <small>-1's</small></h2>
                        @foreach($gist->getNegativeVotes()->all() as $voter)
                            <a href="{{ $voter->profile() }}" target="_blank">
                                <img class="avatar img-responsive" src="{{ $voter->avatar() }}" alt="{{ $voter->username() }}">
                            </a>
                        @endforeach
                    </div>
                @endif
            @else
                <p class="text-muted">Sorry, no votes yet...</p>
            @endif
        </div>
        <div class="col-xs-12 col-md-9">
            @if($gist->fileCount > 0)
                <ul id="gist_list" class="list-group">
                    @foreach($gist->files->all() as $file)
                        <div class="media">
                            <div class="media-body">
                                <h3 class="media-heading">{{ $file->name }}</h3>

                                {!! $file->renderFileHtml() !!}
                            </div>
                        </div>
                    @endforeach
                </ul>
            @endif

            @if($gist->commentCount > 0)
                @foreach($gist->comments as $comment)
                    <article class="media comment">
                        <div class="media-left">
                            <a href="{{ $comment->profile() }}" target="_blank">
                                <img class="media-object avatar img-circle" src="{{ $comment->avatar() }}" alt="{{ $comment->username() }}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="{{ $comment->profile() }}" target="_blank">{{ $comment->username() }}</a></h4>
                            {!! $comment->renderHtml() !!}
                        </div>
                    </article>
                @endforeach
            @endif

            @if($currentUser)
                <article class="media comment">
                    <div class="media-left">
                        <a href="{{ $currentUser->profile() }}" target="_blank">
                            <img class="media-object avatar img-circle" src="{{ $currentUser->avatar() }}" alt="{{ $currentUser->username() }}">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><a href="{{ $currentUser->profile() }}" target="_blank">{{ $currentUser->username() }}</a> <small class="pull-right">Use +1 or -1 in your comment to leave a vote.</small></h4>
                        {!! Form::open(['route' => ['gists.store', $gist->owner, $gist->id], 'method' => 'post']) !!}
                        <!-- Comment Form Input -->
                        <div class="form-group">
                            {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Submit Form Input -->
                        <div class="form-group">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </article>
            @else
                <article class="media comment">
                    <div class="media-body">
                        <p><a href="{{ route('login') }}"><i class="fa fa-github"></i> Login with GitHub to comment/vote.</a></p>
                    </div>
                </article>
            @endif
        </div>
    </div>
@stop
