<?php namespace Gistvote\Services;

use Gistvote\Users\User;
use Github\Client as GitHubClient;

class GitHub
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var GitHubClient
     */
    private $client;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->client = new GitHubClient();

        $this->authenticate();
    }

    /**
     * Authenticates the current user for the upcoming API calls
     */
    private function authenticate()
    {
        try {
            $this->client->authenticate($this->user->token, $this->user->token, GitHubClient::AUTH_HTTP_TOKEN);
        } catch (\Exception $e) {
            // @todo: handle this better...
            die($e->getMessage());
        }
    }

    /**
     * Returns all of the user's gists. Public and Secret.
     *
     * @return mixed
     */
    public function gists()
    {
        return $this->client->api('gists')->all();
    }

    /**
     * Returns a specific gist
     *
     * @param $id
     * @return mixed
     */
    public function gist($id)
    {
        return $this->client->api('gists')->show($id);
    }
}
