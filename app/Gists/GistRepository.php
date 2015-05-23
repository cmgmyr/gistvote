<?php namespace Gistvote\Gists;

use Carbon\Carbon;

class GistRepository
{
    /**
     * Gets all gists created by the user
     *
     * @param int $userId
     * @return mixed
     */
    public function all($userId)
    {
        return Gist::where('user_id', $userId)->latest()->get();
    }

    /**
     * @param array $gistData
     * @param int $userId
     * @return static
     */
    public function findByIdOrCreate($gistData, $userId)
    {
        $gist = Gist::firstOrCreate([
            'id' => $gistData['id'],
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

        return $gist;
    }
}
