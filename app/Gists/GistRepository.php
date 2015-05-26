<?php namespace Gistvote\Gists;

use Carbon\Carbon;

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
}
