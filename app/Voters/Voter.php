<?php namespace Gistvote\Voters;

class Voter
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $avatar;

    public function __construct($username, $avatar)
    {
        $this->username = $username;
        $this->avatar = $avatar;
    }
}
