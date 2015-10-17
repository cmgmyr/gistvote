<?php

namespace Gistvote\Listeners;

use Gistvote\Events\GistWasActivated;
use Gistvote\Services\GitHub;

class AddPoweredByComment
{
    /**
     * Handle the event.
     *
     * @param GistWasActivated $event
     */
    public function handle(GistWasActivated $event)
    {
        $gist = $event->gist;
        $gitHub = new GitHub($gist->user);

        if (!$gist->has_powered_by) {
            $gistUrl = route('gists.show', ['username' => $gist->user->username(), 'id' => $gist->id]);
            $comment = 'This gist has vote tracking powered by [Gist.vote](' . $gistUrl . ')';

            $gitHub->gistComment($gist->id, $comment);
            $gist->has_powered_by = true;
            $gist->save();
        }
    }
}
