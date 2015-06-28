@extends('layouts.app')

@section('content')
    <h1>{{ $gist->firstFile()->name }}</h1>
    <p>{{ $gist->description }}</p>

    <div class="row">
        <div class="col-xs-12 col-md-3 vote_tallies">
            @if($gist->getPositiveVotes()->count() > 0)
                <div class="alert alert-success">
                    <h2>+1's</h2>
                    @foreach($gist->getPositiveVotes()->all() as $voter)
                        <a href="{{ $voter->profile() }}" target="_blank">
                            <img class="avatar img-circle" src="{{ $voter->avatar() }}" alt="{{ $voter->username() }}">
                        </a>
                    @endforeach
                </div>
            @endif

            @if($gist->getNegativeVotes()->count() > 0)
                <div class="alert alert-danger">
                    <h2>+1's</h2>
                    @foreach($gist->getNegativeVotes()->all() as $voter)
                        <a href="{{ $voter->profile() }}" target="_blank">
                            <img class="avatar img-circle" src="{{ $voter->avatar() }}" alt="{{ $voter->username() }}">
                        </a>
                    @endforeach
                </div>
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
        </div>
    </div>
@stop
