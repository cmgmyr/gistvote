<?php

use Gistvote\Gists\Gist;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GistTest extends TestCase
{
    use DatabaseMigrations, GistFixtureHelpers;

    /** @test */
    public function it_should_return_a_gist_from_an_eloquent_object()
    {
        $eloquentGist = $this->buildEloquentGist();
        $gist = Gist::fromEloquent($eloquentGist);

        $this->assertInstanceOf(Gist::class, $gist);
    }

    /** @test */
    public function it_should_return_a_gist_from_github_api_data()
    {
        list($eloquentGist, $githubGist) = $this->buildGithubGist();
        $gist = Gist::fromGitHub($eloquentGist, $githubGist);

        $this->assertInstanceOf(Gist::class, $gist);
    }

    /**
     * Builds an eloquent gist for testing
     *
     * @return mixed
     */
    protected function buildEloquentGist()
    {
        $user = factory(Gistvote\Users\User::class)->create();
        $eloquentGist = factory(Gistvote\Gists\EloquentGist::class)->create();
        $eloquentGist->user()->associate($user);
        $eloquentGist->save();

        return $eloquentGist;
    }

    /**
     * Builds a Github gist for testing
     *
     * @return array
     */
    protected function buildGithubGist()
    {
        $eloquentGist = $this->buildEloquentGist();
        $gistData = $this->loadFixture('5300bf315d8f29864d9b.json');
        $gistComments = $this->loadFixture('5300bf315d8f29864d9b/comments.json');
        $githubGist = ['gist' => $gistData, 'comments' => $gistComments];

        return array($eloquentGist, $githubGist);
    }
}
