<?php namespace Gistvote\Auth;

use Gistvote\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard as Auth;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AuthenticateUser
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var Socialite
     */
    private $socialite;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @param UserRepository $users
     * @param Socialite $socialite
     * @param Auth $auth
     */
    public function __construct(UserRepository $users, Socialite $socialite, Auth $auth)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;
    }

    /**
     * If code is available, create or update the user, then log in
     *
     * @param boolean $hasCode
     * @param AuthenticateUserListener $listener
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute($hasCode, AuthenticateUserListener $listener)
    {
        if (!$hasCode) {
            return $this->getAuthorizationFirst();
        }

        $user = $this->users->findByUsernameOrCreate($this->getGithubUser());

        $this->auth->login($user, true);

        return $listener->userHasLoggedIn($user);
    }

    /**
     * Redirect to the authentication URL
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst()
    {
        return $this->socialite->driver('github')->redirect();
    }

    /**
     * Gets the user information from GitHub
     *
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getGithubUser()
    {
        return $this->socialite->driver('github')->user();
    }
}
