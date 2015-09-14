@extends('layouts.app')

@section('content')
    <h1>Your Gists <a href="{{ route('gists.refresh') }}" class="refresh" title="Refresh Gists"><i class="fa fa-refresh"></i></a></h1>

    @if($gists->count() > 0)
        <ul id="gist_list" class="list-group">
        @foreach($gists->all() as $gist)
            @include('gists/partials/list-gist', ['gist' => $gist])
        @endforeach
        </ul>
    @endif

    {!! $pagination !!}
@stop
