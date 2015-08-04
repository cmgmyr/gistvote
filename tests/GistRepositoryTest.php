<?php

use Gistvote\Gists\EloquentGist;
use Gistvote\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GistRepositoryTest extends TestCase
{
    use DatabaseMigrations, GistFixtureHelpers;

    /** @test */
    public function it_should_return_all_gists_from_a_user()
    {
        $user = factory(User::class)->create();
        $gist1 = factory(EloquentGist::class)->create();
        $gist2 = factory(EloquentGist::class)->create([
            'id' => '5300bf315d8f29864d9b_2',
        ]);

        $repo = new \Gistvote\Gists\GistRepository();
        $gists = $repo->all($user->id);

        $this->assertCount(2, $gists);
        $this->assertInstanceOf(Gistvote\Gists\Gist::class, $gists->first());
    }

    /** @test */
    public function it_should_create_a_new_eloquent_gist_from_api()
    {
        $user = factory(User::class)->create();

        $githubGist = $this->loadFixture('5300bf315d8f29864d9b.json');

        $repo = new \Gistvote\Gists\GistRepository();
        $gist = $repo->findByIdOrCreate($githubGist, $user->id);

        $this->assertInstanceOf(Gistvote\Gists\Gist::class, $gist);
    }
}
