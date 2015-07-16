<?php
namespace Gistvote\Users;

interface GitHubUser
{
    /**
     * Returns the username for the user
     *
     * @return string
     */
    public function username();

    /**
     * Returns the profile url for the user
     *
     * @return string
     */
    public function profile();

    /**
     * Returns the avatar url for the user
     *
     * @return string
     */
    public function avatar();
}
