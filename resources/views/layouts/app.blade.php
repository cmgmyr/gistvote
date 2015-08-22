<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GistVote - Turn Your Gists Into a Voting Platform</title>
    @yield('meta')

    <link rel="stylesheet" href="{{ elixir("css/app.css") }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}">GistVote</a>
            </div>

            @if($currentUser)
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" name="user-dropdown">
                                <img class="avatar nav-avatar img-circle" src="{{$currentUser->avatar}}" alt="{{$currentUser->name}}">
                                {{ $currentUser->first_name}} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @else
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="{{ route('login') }}"><i class="fa fa-github"></i> Log in with GitHub</a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </nav>

    <div class="container">
        <div class="content">
            @include('common.flash')

            @yield('content')
        </div>
    </div>

    <footer class="footer">
        <div class="container text-muted">
            <ul class="list-inline">
                <li>Copyright &copy; <a href="https://github.com/cmgmyr" target="_blank">Chris Gmyr</a></li>
                <li class="pull-right"><a href="https://github.com/cmgmyr/gistvote" target="_blank"><i class="fa fa-github"></i> Report a bug, make a suggestion, or contribute</a></li>
            </ul>
        </div>
    </footer>

    <script src="{{ elixir("js/app.js") }}"></script>
    @yield('scripts')
</body>
</html>
