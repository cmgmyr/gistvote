<?php

use Gistvote\Voters\Voter;

class VoterTest extends TestCase
{
    /** @test */
    public function it_can_create_a_voter()
    {
        $username = 'cmgmyr';
        $avatar = 'https://avatars.githubusercontent.com/u/4693481?v=3';

        $voter = new Voter($username, $avatar);

        $this->assertEquals('cmgmyr', $voter->username());
        $this->assertEquals('https://avatars.githubusercontent.com/u/4693481?v=3', $voter->avatar());
        $this->assertEquals('https://github.com/cmgmyr', $voter->profile());
    }
}
