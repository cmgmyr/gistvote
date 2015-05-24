<?php namespace Gistvote\Gists;

use Carbon\Carbon;

class Gist
{
    public $id;
    public $description;

    /**
     * @var Collection
     */
    public $comments;
    public $commentCount;

    /**
     * @var Collection
     */
    public $files;
    public $fileCount;

    /**
     * @var Carbon
     */
    public $created_at;

    /**
     * @var Carbon
     */
    public $updated_at;

    /**
     * @var Carbon
     */
    public $last_scan;

    private $public;

    public static function fromEloquent($eloquentGist)
    {
        $gist = new self;

        $gist->id = $eloquentGist->id;
        $gist->description = $eloquentGist->description;
        $gist->public = $eloquentGist->public;

        $gist->comments = collect(); // we don't store comments in the db right now
        $gist->commentCount = $eloquentGist->comments;

        $gist->files = collect([
            new GistFile($eloquentGist->file, $eloquentGist->file_language, $eloquentGist->file_content)
        ]);
        $gist->fileCount = $eloquentGist->files;

        $gist->created_at = $eloquentGist->created_at;
        $gist->updated_at = $eloquentGist->updated_at;
        $gist->last_scan = $eloquentGist->last_scan;

        return $gist;
    }

    public function firstFile()
    {
        return $this->files->first();
    }

    public function isPublic()
    {
        return $this->public;
    }

    public function isSecret()
    {
        return !$this->isPublic();
    }
}
