<?php

namespace Gistvote\Gists;

use Carbon\Carbon;
use Gistvote\Services\GitHub;
use Gistvote\Users\GitHubUser;
use Gistvote\Voters\Voter;

class GistComment implements GitHubUser
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var array
     */
    private $user;

    /**
     * @var string
     */
    public $body;

    /**
     * @var Carbon
     */
    public $created_at;

    /**
     * @var Carbon
     */
    public $updated_at;

    /**
     * @var null|string
     */
    private $vote = null;

    /**
     * @var Gist
     */
    private $gist;

    public function __construct($data, Gist $gist)
    {
        $defaults = [
            'id'         => null,
            'user'       => null,
            'body'       => null,
            'created_at' => null,
            'updated_at' => null,
        ];
        $data = array_merge($defaults, $data);

        $this->id = $data['id'];
        $this->user = $data['user'];
        $this->body = $data['body'];
        $this->created_at = Carbon::parse($data['created_at']);
        $this->updated_at = Carbon::parse($data['updated_at']);

        $this->gist = $gist;
        $this->parseForVotes();
    }

    /**
     * Returns the user's username.
     *
     * @return string
     */
    public function username()
    {
        return $this->user['login'];
    }

    /**
     * Returns the user's avatar.
     *
     * @return string
     */
    public function avatar()
    {
        return $this->user['avatar_url'];
    }

    /**
     * Returns the user's profile URL.
     *
     * @return string
     */
    public function profile()
    {
        return $this->user['html_url'];
    }

    /**
     * Transforms the raw/markdown content to html.
     *
     * @return string
     */
    public function renderHtml()
    {
        return (new GitHub($this->gist->user))->parseMarkdown($this->body);
    }

    /**
     * This will update the comment vote if there is a -1 or +1 found.
     * We'll take the positive vote in case there is an off chance
     * where both are found.
     */
    private function parseForVotes()
    {
        $voter = new Voter($this->username(), $this->avatar());

        if (str_contains($this->body, '-1')) {
            $this->vote = 'n';

            $this->gist->setNegativeVote($voter);
        }

        if (str_contains($this->body, '+1')) {
            $this->vote = 'y';

            $this->gist->setPositiveVote($voter);
        }
    }

    /**
     * Checks to see if the comment has a vote.
     *
     * @return bool
     */
    public function hasVote()
    {
        if ($this->vote === null) {
            return false;
        }

        return true;
    }

    /**
     * Checks to see if the comment has a positive (+1) vote.
     *
     * @return bool
     */
    public function hasPositiveVote()
    {
        if ($this->vote != 'y') {
            return false;
        }

        return true;
    }

    /**
     * Checks to see if the comment has a negative (-1) vote.
     *
     * @return bool
     */
    public function hasNegativeVote()
    {
        if ($this->vote != 'n') {
            return false;
        }

        return true;
    }
}
