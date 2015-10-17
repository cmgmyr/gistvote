<?php

namespace Gistvote\Http\Controllers;

use Exception;
use Gistvote\Gists\GistRepository;
use Gistvote\Services\GitHub;
use Gistvote\Services\Notifications\Flash;
use Illuminate\Contracts\Auth\Guard as Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

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

    private $gistNotFoundMessage = 'The gist you were trying to access is not available right now. Please try again later.';

    /**
     * Enable auth middleware, redirect if not logged in.
     *
     * @param Auth $auth
     * @param GistRepository $repository
     */
    public function __construct(Auth $auth, GistRepository $repository)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);

        $this->auth = $auth;
        $this->repository = $repository;
        if ($this->auth->check()) {
            $this->github = new GitHub($this->auth->user());
        }
    }

    /**
     * Shows all of the user's gists.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!$this->auth->check()) {
            return view('welcome');
        }

        list($gists, $pagination) = $this->repository->paginateAll($this->auth->id(), 10);

        return view('gists.index')->with('gists', $gists)->with('pagination', $pagination);
    }

    /**
     * Refreshes the user's gists in the database.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function refresh()
    {
        $gists = $this->github->gists();

        $this->repository->setAllGistsToBeDeletedByUser($this->auth->id());

        foreach ($gists as $gist) {
            $this->repository->findByIdOrCreate($gist, $this->auth->id());
        }

        $this->repository->removeDeletableGistsByUser($this->auth->id());

        return redirect('/');
    }

    /**
     * Shows the view page for a Gist.
     *
     * @param $username
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($username, $id)
    {
        try {
            $gist = $this->repository->findById($id);
        } catch (Exception $e) {
            Flash::error($this->gistNotFoundMessage);

            return redirect('/');
        }

        if ($username != $gist->owner || $gist->isNotVoting()) {
            Flash::error($this->gistNotFoundMessage);

            return redirect('/');
        }

        return view('gists.show')->with('gist', $gist);
    }

    /**
     * Saves a new comment/vote to a gist.
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
            Flash::error($this->gistNotFoundMessage);

            return redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            Flash::validation($validator->errors());

            return redirect()->back()->withInput();
        }

        $comment = Input::get('comment');

        $this->github->gistComment($id, $comment);

        Flash::success('Your comment was successfully posted.');

        return redirect()->route('gists.show', [$username, $id]);
    }

    /**
     * Activates a Gist for voting.
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
     * Deactivates a Gist for voting.
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
