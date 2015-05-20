@extends('layouts.app')

@section('content')
    <h1>Your Gists <a href="{{ route('gists.refresh') }}" class="refresh" title="Refresh Gists"><i class="fa fa-refresh"></i></a></h1>

    @if(count($gists))
        <ul>
        @foreach($gists as $gist)
            <li>{{ $gist->file }} @if(!$gist->public)<i class="fa fa-lock"></i>@endif</li>
        @endforeach
        </ul>
    @endif
@stop
