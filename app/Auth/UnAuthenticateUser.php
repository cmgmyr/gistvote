<?php namespace Gistvote\Auth;

use Illuminate\Contracts\Auth\Guard as Auth;

class UnAuthenticateUser
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Log the user out
     *
     * @param UnAuthenticateUserListener $listener
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute(UnAuthenticateUserListener $listener)
    {
        $this->auth->logout();

        return $listener->userHasLoggedOut();
    }
}
