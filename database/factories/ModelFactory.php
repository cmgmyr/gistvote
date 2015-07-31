<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Gistvote\Users\User::class, function () {
    return [
        'id'             => 1,
        'name'           => 'Chris Gmyr',
        'username'       => 'cmgmyr',
        'email'          => 'cmgmyr@gmail.com',
        'token'          => str_random(10),
        'avatar'         => 'https://avatars.githubusercontent.com/u/4693481?v=3',
        'remember_token' => str_random(10),
    ];
});

$factory->define(Gistvote\Gists\EloquentGist::class, function () {
    return [
        'id'             => '5300bf315d8f29864d9b',
        'user_id'        => 1,
        'file'           => 'testing.md',
        'file_language'  => 'Markdown',
        'file_content'   => "# This is a test gist\n\nDoes it work?",
        'description'    => 'Test Gist',
        'public'         => false,
        'files'          => 3,
        'comments'       => 1,
        'enable_voting'  => true,
        'has_powered_by' => true,
        'created_at'     => \Carbon\Carbon::now(),
        'updated_at'     => \Carbon\Carbon::now(),
        'last_scan'      => \Carbon\Carbon::now(),
    ];
});
