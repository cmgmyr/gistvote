<?php namespace Gistvote\Http\Controllers;

use Gistvote\Gists\GistRepository;
use Gistvote\Services\GitHub;
use Illuminate\Contracts\Auth\Guard as Auth;

class GistsController extends Controller
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var GistRepository
     */
    private $repository;

    /**
     * Enable auth middleware, redirect if not logged in.
     *
     * @param Auth $auth
     * @param GistRepository $repository
     */
    public function __construct(Auth $auth, GistRepository $repository)
    {
        $this->middleware('auth', ['except' => 'index']);

        $this->auth = $auth;
        $this->repository = $repository;
    }

    /**
     * Shows all of the user's gists
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!$this->auth->check()) {
            return view('welcome');
        }

        $gists = $this->repository->all($this->auth->id());

        return view('gists.index')->with('gists', $gists);
    }

    /**
     * Refreshes the user's gists in the database
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function refresh()
    {
        $user = $this->auth->user();
        $gh = new GitHub($user);

        $gists = $gh->gists();

        foreach ($gists as $gist) {
            $this->repository->findByIdOrCreate($gist, $user->id);
        }

        return redirect('/');
    }

    /**
     * Activates a Gist for voting
     *
     * @param $id
     * @return array
     */
    public function activateGist($id)
    {
        $this->repository->activate($id, $this->auth->id());

        return ['status' => 'OK'];
    }

    /**
     * Deactivates a Gist for voting
     *
     * @param $id
     * @return array
     */
    public function deactivateGist($id)
    {
        $this->repository->deactivate($id, $this->auth->id());

        return ['status' => 'OK'];
    }
}
