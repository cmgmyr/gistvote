<?php namespace Gistvote\Voters;

use Gistvote\Users\GitHubUser;

class Voter implements GitHubUser
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $avatar;

    public function __construct($username, $avatar)
    {
        $this->username = $username;
        $this->avatar = $avatar;
    }

    /**
     * Returns the username for the user
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * Returns the profile url for the user
     *
     * @return string
     */
    public function profile()
    {
        return 'https://github.com/' . $this->username;
    }

    /**
     * Returns the avatar url for the user
     *
     * @return string
     */
    public function avatar()
    {
        return $this->avatar;
    }
}
