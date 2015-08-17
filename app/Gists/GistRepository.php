<?php namespace Gistvote\Gists;

use Carbon\Carbon;
use Exception;
use Gistvote\Events\GistWasActivated;
use Gistvote\Services\GitHub;
use Illuminate\Support\Facades\Event;

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

        // handle file content
        $gist = $this->getGistFileContent($gist, $gistData['files'][$gist->file]['raw_url']);

        $gist->description = $gistData['description'];
        $gist->public = $gistData['public'];
        $gist->files = count($gistData['files']);
        $gist->comments = $gistData['comments'];
        $gist->created_at = Carbon::parse($gistData['created_at']);
        $gist->updated_at = Carbon::parse($gistData['updated_at']);
        $gist->last_scan = Carbon::now();
        $gist->should_delete = false;

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
     */
    public function activate($id, $userId)
    {
        $gist = EloquentGist::where('id', $id)->where('user_id', $userId)->first();
        $gist->enable_voting = true;
        $gist->save();

        Event::fire(new GistWasActivated($gist));
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

            // handle file content
            $gist = $this->getGistFileContent($gist, $gitHubGist['gist']['files'][$gist->file]['raw_url']);

            $gist->description = $gitHubGist['gist']['description'];
            $gist->public = $gitHubGist['gist']['public'];
            $gist->files = count($gitHubGist['gist']['files']);
            $gist->comments = count($gitHubGist['comments']);
            $gist->created_at = Carbon::parse($gitHubGist['gist']['created_at']);
            $gist->updated_at = Carbon::parse($gitHubGist['gist']['updated_at']);
            $gist->last_scan = Carbon::now();
            $gist->should_delete = false;

            $gist->save();
        }
    }

    /**
     * Set all gists for a user to be (possibly) deleted in the future
     *
     * @param $userId
     */
    public function setAllGistsToBeDeletedByUser($userId)
    {
        EloquentGist::where('user_id', $userId)->update(['should_delete' => true]);
    }

    /**
     * Delete gists by a user that are still set to be deleted
     *
     * @param $userId
     */
    public function removeDeletableGistsByUser($userId)
    {
        EloquentGist::where('user_id', $userId)->where('should_delete', true)->delete();
    }

    /**
     * Handles any exceptions when we can't get the gist contents (when GH is down)
     *
     * @param EloquentGist $gist
     * @param $fileUrl
     * @return mixed
     */
    protected function getGistFileContent(EloquentGist $gist, $fileUrl)
    {
        try {
            $gist->file_content = file_get_contents($fileUrl);
        } catch (Exception $e) {
            $gist->file_language = 'Markdown';
            $gist->file_content = <<<CONTENT
# :rage: We're sorry, there was an error

Looks like something is wrong retrieving the file from GitHub. Please check back soon
CONTENT;
        }

        return $gist;
    }
}
