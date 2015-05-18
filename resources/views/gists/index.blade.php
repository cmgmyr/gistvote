<html>
<head>
    <title>Your Gists</title>
</head>
<body>
<div class="container">
    <div class="content">
        @if(count($gists))
            <ul>
            @foreach($gists as $gist)
                <li>{{ $gist->file }}</li>
            @endforeach
            </ul>
        @endif
        <a href="/gists/refresh">Refresh</a>
    </div>
</div>
</body>
</html>
