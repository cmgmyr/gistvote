<?php namespace Gistvote\Auth;

interface AuthenticateUserListener
{
    /**
     * When a user has successfully been logged in
     *
     * @param $user
     * @return \Illuminate\Routing\Redirector
     */
    public function userHasLoggedIn($user);
}
