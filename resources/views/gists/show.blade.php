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
                    @include('gists.partials.comment', ['comment' => $comment])
                @endforeach
            @endif

            @if($currentUser)
                    <div class="row comment">
                        <div class="col-sm-1">
                            <div class="thumbnail">
                                <a href="{{ $currentUser->profile() }}" target="_blank">
                                    <img class="img-responsive user-photo" src="{{ $currentUser->avatar() }}">
                                </a>
                            </div><!-- /thumbnail -->
                        </div><!-- /col-sm-1 -->

                        <div class="col-sm-10">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <strong><a href="{{ $currentUser->profile() }}" target="_blank">{{ $comment->username() }}</a></strong> <small class="pull-right">Use +1 or -1 in your comment to leave a vote.</small>
                                </div>
                                <div class="panel-body">
                                    {!! Form::open(['route' => ['gists.store', $gist->owner, $gist->id], 'method' => 'post']) !!}
                                    <!-- Comment Form Input -->
                                    <div class="form-group">
                                        {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
                                    </div>

                                    <!-- Submit Form Input -->
                                    <div class="">
                                        {!! Form::submit('Comment', ['class' => 'btn btn-success pull-right']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div><!-- /panel-body -->
                            </div><!-- /panel panel-default -->
                        </div><!-- /col-sm-5 -->
                    </div>
            @else
                <article class="media">
                    <div class="media-body">
                        <p><a href="{{ route('login') }}" class="btn btn-lg btn-success"><i class="fa fa-github"></i> Log In to Comment and Vote.</a></p>
                    </div>
                </article>
            @endif
        </div>
    </div>
@stop
