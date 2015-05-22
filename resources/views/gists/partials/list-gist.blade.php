<li class="list-group-item">
    <div class="media">
        <div class="media-body">
            <div class="row">
                <div class="col-md-9">
                    <h3 class="media-heading"><a href="">{{ $gist->file }}</a> @if(!$gist->public)<i class="fa fa-lock"></i>@endif</h3>
                    <p class="text-muted">Created {{ $gist->created_at->diffForHumans() }}</p>
                    <p>{{ $gist->description }}</p>
                </div>
                <div class="col-md-3 text-right">
                    <ul class="list-inline">
                        <li><i class="fa fa-code"></i> {{ $gist->files }} Files</li>
                        <li><i class="fa fa-comments"></i> {{ $gist->comments }} comment(s)</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <pre><code class="language-{{ $gist->file_language_highlight }} line-numbers">{{ $gist->file_content_snippet }}</code></pre>
                </div>
            </div>
        </div>
    </div>
</li>
