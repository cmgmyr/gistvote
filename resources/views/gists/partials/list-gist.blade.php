<li class="list-group-item">
    <div class="media">
        <div class="media-body">
            <div class="row">
                <div class="col-md-9">
                    <h3 class="media-heading"><a href="{{ $gist->url() }}">{{ $gist->firstFile()->name }}</a> @if($gist->isSecret())<i class="fa fa-lock"></i>@endif</h3>
                    <p class="text-muted">Created {{ $gist->created_at->diffForHumans() }}</p>
                    <p>{{ $gist->description }}</p>
                </div>
                <div class="col-md-3 text-right">
                    <ul class="list-inline">
                        <li><i class="fa fa-code"></i> {{ $gist->fileCount }} Files</li>
                        <li><i class="fa fa-comments"></i> {{ $gist->commentCount }} comment(s)</li>
                        <li><input type="checkbox" class="enable_voting" @if($gist->isVoting()) checked @endif data-id="{{ $gist->id }}" data-toggle="toggle"></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {!! $gist->firstFile()->renderSnippetHtml() !!}
                </div>
            </div>
        </div>
    </div>
</li>
