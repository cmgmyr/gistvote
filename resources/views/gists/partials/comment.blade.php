<div class="row comment">
    <div class="col-sm-1">
        <div class="thumbnail">
            <a href="{{ $comment->profile() }}" target="_blank">
                <img class="img-responsive" src="{{ $comment->avatar() }}">
            </a>
        </div>
    </div>

    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><a href="{{ $comment->profile() }}" target="_blank">{{ $comment->username() }}</a></strong> <span class="text-muted">commented {{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <div class="panel-body">
                {!! $comment->renderHtml() !!}
            </div>
        </div>
    </div>
</div>
