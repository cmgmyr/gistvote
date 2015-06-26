<?php namespace Gistvote\Gists;

use Carbon\Carbon;
use Gistvote\Voters\Voter;

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
     * @var bool
     */
    private $voting;

    /**
     * @var string
     */
    public $owner;

    /**
     * @var array
     */
    private $voters;

    public function __construct()
    {
        $this->voters = [
            'positive' => collect(),
            'negative' => collect(),
        ];
    }

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
        $gist->voting = $eloquentGist->enable_voting;

        $gist->comments = collect(); // we don't store comments in the db right now
        $gist->commentCount = $eloquentGist->comments;

        $gist->files = collect([
            new GistFile($eloquentGist->file, $eloquentGist->file_language, $eloquentGist->file_content)
        ]);
        $gist->fileCount = $eloquentGist->files;

        $gist->created_at = $eloquentGist->created_at;
        $gist->updated_at = $eloquentGist->updated_at;
        $gist->last_scan = $eloquentGist->last_scan;
        $gist->owner = $eloquentGist->user->username;

        return $gist;
    }

    /**
     * Creates a new Gist from the GitHub API
     *
     * @param EloquentGist $eloquentGist
     * @param $gitHubGist
     * @return Gist
     */
    public static function fromGitHub(EloquentGist $eloquentGist, $gitHubGist)
    {
        $gist = new self;

        $gist->id = $gitHubGist['gist']['id'];
        $gist->description = $gitHubGist['gist']['description'];
        $gist->public = $gitHubGist['gist']['public'];
        $gist->voting = $eloquentGist->enable_voting;

        $comments = [];
        if (is_array($gitHubGist['comments'])) {
            foreach ($gitHubGist['comments'] as $comment) {
                $comments[] = new GistComment($comment, $gist);
            }
        }
        $gist->comments = collect($comments);
        $gist->commentCount = $gist->comments->count();

        $files = [];
        if (is_array($gitHubGist['gist']['files'])) {
            foreach ($gitHubGist['gist']['files'] as $file) {
                $files[] = new GistFile($file['filename'], $file['language'], $file['content']);
            }
        }
        $gist->files = collect($files);
        $gist->fileCount = $gist->files->count();

        $gist->created_at = Carbon::parse($gitHubGist['gist']['created_at']);
        $gist->updated_at = Carbon::parse($gitHubGist['gist']['updated_at']);
        $gist->owner = $gitHubGist['gist']['owner']['login'];

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

    /**
     * Sees if the Gist is open for voting
     *
     * @return bool
     */
    public function isVoting()
    {
        return $this->voting;
    }

    /**
     * Sees if the Gist is not open for voting
     *
     * @return bool
     */
    public function isNotVoting()
    {
        return !$this->isVoting();
    }

    /**
     * Generates the "show" url for the Gist
     *
     * @return string
     */
    public function url()
    {
        return route('gists.show', [$this->owner, $this->id]);
    }

    /**
     * Adds a new negative voter
     *
     * @param Voter $voter
     */
    public function setNegativeVote(Voter $voter)
    {
        $this->voters['negative']->push($voter);
    }

    /**
     * Adds a new positive voter
     *
     * @param Voter $voter
     */
    public function setPositiveVote(Voter $voter)
    {
        $this->voters['positive']->push($voter);
    }
}
