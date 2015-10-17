<?php

namespace Gistvote\Http\ViewComposers;

use Illuminate\Contracts\Auth\Guard as Auth;
use Illuminate\Contracts\View\View;

class AppComposer
{
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function compose(View $view)
    {
        $view->with('currentUser', $this->auth->user());
    }
}
