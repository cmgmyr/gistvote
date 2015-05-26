<?php namespace Gistvote\Gists;

use Carbon\Carbon;

class Gist
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $description = '';

    /**
     * @var Collection
     */
    public $comments;

    /**
     * @var int
     */
    public $commentCount;

    /**
     * @var Collection
     */
    public $files;

    /**
     * @var int
     */
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

    /**
     * @var bool
     */
    private $public;

    /**
     * Creates a new Gist object from Eloquent
     *
     * @param EloquentGist $eloquentGist
     * @return Gist
     */
    public static function fromEloquent(EloquentGist $eloquentGist)
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

    /**
     * Returns the first file of the Gist
     *
     * @return GistFile
     */
    public function firstFile()
    {
        return $this->files->first();
    }

    /**
     * Sees if the Gist is public
     *
     * @return bool
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * Sees if the Gist is not public
     *
     * @return bool
     */
    public function isSecret()
    {
        return !$this->isPublic();
    }
}
