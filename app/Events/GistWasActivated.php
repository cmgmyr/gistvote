<?php namespace Gistvote\Events;

use Gistvote\Gists\EloquentGist;
use Illuminate\Queue\SerializesModels;

class GistWasActivated extends Event
{
    use SerializesModels;

    /**
     * @var EloquentGist
     */
    public $gist;

    /**
     * Create a new event instance.
     *
     * @param EloquentGist $gist
     */
    public function __construct(EloquentGist $gist)
    {
        $this->gist = $gist;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
