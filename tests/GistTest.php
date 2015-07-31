<?php

use Gistvote\Gists\Gist;
use Gistvote\Gists\GistFile;
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

    /** @test */
    public function it_should_return_first_file()
    {
        $gistFromEloquent = Gist::fromEloquent($this->buildEloquentGist());

        $this->assertInstanceOf(GistFile::class, $gistFromEloquent->firstFile());

        list($eloquentGist, $githubGist) = $this->buildGithubGist(['id' => 2, 'email' => 'chris@gist.vote'], ['user_id' => 2]);
        $gistFromGithub = Gist::fromGitHub($eloquentGist, $githubGist);

        $this->assertInstanceOf(GistFile::class, $gistFromGithub->firstFile());
    }

    /**
     * Builds an eloquent gist for testing
     *
     * @param array $userOverrides
     * @param array $gistOverrides
     * @return mixed
     */
    protected function buildEloquentGist($userOverrides = [], $gistOverrides = [])
    {
        $user = factory(Gistvote\Users\User::class)->create($userOverrides);
        $eloquentGist = factory(Gistvote\Gists\EloquentGist::class)->create($gistOverrides);
        $eloquentGist->user()->associate($user);
        $eloquentGist->save();

        return $eloquentGist;
    }

    /**
     * Builds a Github gist for testing
     *
     * @param array $userOverrides
     * @param array $gistOverrides
     * @return array
     */
    protected function buildGithubGist($userOverrides = [], $gistOverrides = [])
    {
        $eloquentGist = $this->buildEloquentGist($userOverrides, $gistOverrides);
        $gistData = $this->loadFixture('5300bf315d8f29864d9b.json');
        $gistComments = $this->loadFixture('5300bf315d8f29864d9b/comments.json');
        $githubGist = ['gist' => $gistData, 'comments' => $gistComments];

        return [$eloquentGist, $githubGist];
    }
}
