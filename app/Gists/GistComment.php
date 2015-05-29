<?php namespace Gistvote\Gists;

use Carbon\Carbon;
use Michelf\MarkdownExtra;

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

    public function __construct($id, array $user, $body, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->user = $user;
        $this->body = $body;
        $this->created_at = Carbon::parse($created_at);
        $this->updated_at = Carbon::parse($updated_at);
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

    public function renderHtml()
    {
        return MarkdownExtra::defaultTransform($this->body);
    }
}
