<?php namespace Gistvote\Gists;

use Carbon\Carbon;
use Gistvote\Services\GitHub;

class GistRepository
{
    /**
     * Gets all gists created by the user
     *
     * @param int $userId
     * @return Collection
     */
    public function all($userId)
    {
        $gists = EloquentGist::where('user_id', $userId)->latest()->get();

        $gistCollection = collect($gists)->map(function ($gist) {
            return Gist::fromEloquent($gist);
        });

        return $gistCollection;
    }

    /**
     * Find or create a gist in the database
     *
     * @param array $gistData
     * @param int $userId
     * @return Gist
     */
    public function findByIdOrCreate($gistData, $userId)
    {
        $gist = EloquentGist::firstOrCreate([
            'id'      => $gistData['id'],
            'user_id' => $userId
        ]);

        // @todo: fix this file stuff, it's bad
        $gist->file = array_keys($gistData['files'])[0];
        $gist->file_language = $gistData['files'][$gist->file]['language'];
        $gist->file_content = file_get_contents($gistData['files'][$gist->file]['raw_url']);

        $gist->description = $gistData['description'];
        $gist->public = $gistData['public'];
        $gist->files = count($gistData['files']);
        $gist->comments = $gistData['comments'];
        $gist->created_at = Carbon::parse($gistData['created_at']);
        $gist->updated_at = Carbon::parse($gistData['updated_at']);
        $gist->last_scan = Carbon::now();

        $gist->save();

        return Gist::fromEloquent($gist);
    }

    /**
     * Finds a gist by ID. Grabs data from Eloquent and GitHub API
     *
     * @param $id
     * @return Gist
     */
    public function findById($id)
    {
        $eloquentGist = EloquentGist::find($id);
        $gh = new GitHub($eloquentGist->user);

        $gist = $gh->gist($id);

        $this->updateFromGitHub($id, $gist);

        return Gist::fromGitHub($eloquentGist, $gist);
    }

    /**
     * Activates a Gist for voting via Eloquent
     *
     * @param $id
     * @param $userId
     * @param GitHub $gitHub
     */
    public function activate($id, $userId, GitHub $gitHub)
    {
        $gist = EloquentGist::where('id', $id)->where('user_id', $userId)->first();
        $gist->enable_voting = true;

        if (!$gist->has_powered_by) {
            $gistUrl = route('gists.show', ['username' => $gist->user->username(), 'id' => $id]);
            $comment = 'This gist has vote tracking powered by [Gist.vote](' . $gistUrl . ')';

            $gitHub->gistComment($id, $comment);
            $gist->has_powered_by = true;
        }

        $gist->save();
    }

    /**
     * Deactivates a Gist for voting via Eloquent
     *
     * @param $id
     * @param $userId
     */
    public function deactivate($id, $userId)
    {
        $gist = EloquentGist::where('id', $id)->where('user_id', $userId)->first();
        $gist->enable_voting = false;
        $gist->save();
    }

    /**
     * Updates the database from a recently fetched API call to GitHub
     *
     * @param $id
     * @param $gitHubGist
     */
    public function updateFromGitHub($id, $gitHubGist)
    {
        $gist = EloquentGist::find($id);
        if ($gist) {
            // @todo: fix this file stuff, it's bad
            $gist->file = array_keys($gitHubGist['gist']['files'])[0];
            $gist->file_language = $gitHubGist['gist']['files'][$gist->file]['language'];
            $gist->file_content = file_get_contents($gitHubGist['gist']['files'][$gist->file]['raw_url']);

            $gist->description = $gitHubGist['gist']['description'];
            $gist->public = $gitHubGist['gist']['public'];
            $gist->files = count($gitHubGist['gist']['files']);
            $gist->comments = count($gitHubGist['comments']);
            $gist->created_at = Carbon::parse($gitHubGist['gist']['created_at']);
            $gist->updated_at = Carbon::parse($gitHubGist['gist']['updated_at']);
            $gist->last_scan = Carbon::now();

            $gist->save();
        }
    }
}
