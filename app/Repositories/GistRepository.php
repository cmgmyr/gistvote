<?php namespace Gistvote\Repositories;

use Carbon\Carbon;
use Gistvote\Gist;
use Gistvote\User;

class GistRepository
{
    /**
     * Gets all gists created by the user
     *
     * @param User $user
     * @return mixed
     */
    public function all(User $user)
    {
        return Gist::where('user_id', $user->id)->latest()->get();
    }

    /**
     * @param $gistData
     * @return static
     */
    public function findByIdOrCreate($gistData, User $user)
    {
        $gist = Gist::firstOrCreate([
            'id' => $gistData['id'],
            'user_id' => $user->id
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
