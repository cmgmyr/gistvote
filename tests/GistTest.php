<?php

use Gistvote\Gists\Gist;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GistTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_return_a_gist_from_an_eloquent_object()
    {
        $user = factory(Gistvote\Users\User::class)->create();
        $eloquentGist = factory(Gistvote\Gists\EloquentGist::class)->create();
        $eloquentGist->user()->associate($user);
        $eloquentGist->save();

        $gist = Gist::fromEloquent($eloquentGist);

        $this->assertInstanceOf(Gist::class, $gist);
    }
}
