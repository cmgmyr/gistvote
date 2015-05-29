@extends('layouts.app')

@section('content')
    <h1>{{ $gist->firstFile()->name }}</h1>
    <p>{{ $gist->description }}</p>

    @if($gist->fileCount > 0)
        <ul id="gist_list" class="list-group">
            @foreach($gist->files->all() as $file)
                <div class="media">
                    <div class="media-body">
                        @if($gist->firstFile()->name != $file->name)
                        <h3 class="media-heading">{{ $file->name }}</h3>
                        @endif

                        <pre><code class="language-{{ $file->syntaxLanguage() }} line-numbers">{{ $file->content }}</code></pre>
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
@stop
