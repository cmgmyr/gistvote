@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <h1>GistVote</h1>
        <p>Ever have a great idea you wanted to share with others? GistVote makes it simple for you to share, and tally, your voters' responses. For free!</p>
        <p>Import and enable voting options for your gists in seconds. Why not give it a try?</p>
        <p><a class="btn btn-lg btn-success" href="{{ route('login') }}" role="button"><i class="fa fa-github"></i> Get Started With GitHub</a></p>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <h2>Easy to Use</h2>
            <p>You already have a GitHub account, why not make your gists more powerful?</p>
            <img src="/img/turn-on.gif" alt="enable voting">
        </div>
        <div class="col-lg-4">
            <h2>Get Your Idea Across</h2>
            <p>Share and enable voting for any of your current gists. We'll tally up the totals for you so you'll know where your idea stands.</p>
        </div>
        <div class="col-lg-4">
            <h2>Free</h2>
            <p>Yes, the best things in life are actually free!</p>
        </div>
    </div>
@stop
