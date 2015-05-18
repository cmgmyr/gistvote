<?php namespace Gistvote\Http\Controllers;

use Gistvote\Repositories\GistRepository;
use Gistvote\Services\GitHub;
use Illuminate\Contracts\Auth\Guard as Auth;

class GistsController extends Controller
{
    /**
     * @var GistRepository
     */
    private $repository;

    /**
     * Enable auth middleware, redirect if not logged in.
     *
     * @param GistRepository $repository
     */
    public function __construct(GistRepository $repository)
    {
        $this->middleware('auth');

        $this->repository = $repository;
    }

    /**
     * Shows all of the user's gists
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $gists = $this->repository->all();

        return view('gists.index')->with('gists', $gists);
    }

    /**
     * Refreshes the user's gists in the database
     *
     * @param Auth $auth
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function refresh(Auth $auth)
    {
        $user = $auth->user();
        $gh = new GitHub($user);

        $gists = $gh->gists();

        foreach ($gists as $gist) {
            $this->repository->findByIdOrCreate($gist, $user);
        }

        return redirect('gists');
    }
}
