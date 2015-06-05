<?php namespace Gistvote\Gists;

use Carbon\Carbon;
use Gistvote\Parser\ParserFacade as Parser;

class GistComment
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

    public function __construct($id, array $user, $body, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->user = $user;
        $this->body = $body;
        $this->created_at = Carbon::parse($created_at);
        $this->updated_at = Carbon::parse($updated_at);

        $this->parseForVotes();
    }

    /**
     * Returns the user's username
     *
     * @return string
     */
    public function username()
    {
        return $this->user['login'];
    }

    /**
     * Returns the user's avatar
     *
     * @return string
     */
    public function avatar()
    {
        return $this->user['avatar_url'];
    }

    /**
     * Returns the user's profile URL
     *
     * @return string
     */
    public function profile()
    {
        return $this->user['html_url'];
    }

    /**
     * Transforms the raw/markdown content to html
     *
     * @return string
     */
    public function renderHtml()
    {
        return Parser::transform($this->body);
    }

    /**
     * This will update the comment vote if there is a -1 or +1 found.
     * We'll take the positive vote in case there is an off chance
     * where both are found
     */
    private function parseForVotes()
    {
        if (str_contains($this->body, '-1')) {
            $this->vote = 'n';
        }

        if (str_contains($this->body, '+1')) {
            $this->vote = 'y';
        }
    }
}
