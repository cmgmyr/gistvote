@extends('layouts.app')

@section('content')
    <h1>Your Gists <a href="{{ route('gists.refresh') }}" class="refresh" title="Refresh Gists"><i class="fa fa-refresh"></i></a></h1>

    @if(count($gists))
        <ul id="gist_list" class="list-group">
        @foreach($gists as $gist)
            @include('gists/partials/list-gist', $gist)
        @endforeach
        </ul>
    @endif
@stop
