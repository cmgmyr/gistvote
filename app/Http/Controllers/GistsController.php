<?php namespace Gistvote\Http\Controllers;

use Gistvote\Gists\GistRepository;
use Gistvote\Services\GitHub;
use Illuminate\Contracts\Auth\Guard as Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
     * @var GitHub
     */
    private $github = null;

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
        if ($this->auth->check()) {
            $this->github = new GitHub($this->auth->user());
        }
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
        $gists = $this->github->gists();

        foreach ($gists as $gist) {
            $this->repository->findByIdOrCreate($gist, $this->auth->id());
        }

        return redirect('/');
    }

    /**
     * Shows the view page for a Gist
     *
     * @param $username
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($username, $id)
    {
        $gist = $this->repository->findById($id);

        if ($username != $gist->owner || $gist->isNotVoting()) {
            // @todo: show flash message
            return redirect('/');
        }

        return view('gists.show')->with('gist', $gist);
    }

    /**
     * Saves a new comment/vote to a gist
     *
     * @param Request $request
     * @param $username
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, $username, $id)
    {
        $gist = $this->repository->findById($id);

        if ($username != $gist->owner || $gist->isNotVoting()) {
            // @todo: show flash message
            return redirect('/');
        }

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $comment = Input::get('comment');

        $this->github->gistComment($id, $comment);

        // @todo: flash message, comment successful

        return redirect()->route('gists.show', [$username, $id]);
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
