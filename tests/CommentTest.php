<?php

use Gistvote\Gists\Gist;
use Gistvote\Gists\GistComment;
use Mockery as m;

class CommentTest extends TestCase
{
    use GistFixtureHelpers;

    public function tearDown()
    {
        m::close();
    }

    /** @test */
    public function it_can_be_created_from_github_api_data()
    {
        $gist = m::mock(Gist::class);

        $githubComment = $this->loadFixture('5300bf315d8f29864d9b/comments.json')[0];

        $comment = new GistComment($githubComment, $gist);

        $body = "This gist has vote tracking powered by [Gist.vote](http://gistvote.dev/cmgmyr/5300bf315d8f29864d9b)";
        $this->assertEquals($body, $comment->body);
        $this->assertEquals("cmgmyr", $comment->username());
        $this->assertEquals("https://avatars.githubusercontent.com/u/4693481?v=3", $comment->avatar());
        $this->assertEquals("https://github.com/cmgmyr", $comment->profile());
        $this->assertEquals(new DateTime('2015-07-20T15:25:54Z'), $comment->updated_at);
        $this->assertFalse($comment->hasVote());
    }

    /** @test */
    public function it_should_parse_positive_vote()
    {
        $gist = m::mock(Gist::class);
        $gist->shouldReceive('setPositiveVote')->times(1);

        $githubComment = $this->loadFixture('5300bf315d8f29864d9b/comments.json')[1];

        $comment = new GistComment($githubComment, $gist);

        $body = "+1 for good validation!";
        $this->assertEquals($body, $comment->body);
        $this->assertTrue($comment->hasVote());
        $this->assertTrue($comment->hasPositiveVote());
        $this->assertFalse($comment->hasNegativeVote());
    }

    /** @test */
    public function it_should_parse_negative_vote()
    {
        $gist = m::mock(Gist::class);
        $gist->shouldReceive('setNegativeVote')->times(1);

        $githubComment = $this->loadFixture('5300bf315d8f29864d9b/comments.json')[2];

        $comment = new GistComment($githubComment, $gist);

        $body = "-1 for more testing purposes";
        $this->assertEquals($body, $comment->body);
        $this->assertTrue($comment->hasNegativeVote());
        $this->assertFalse($comment->hasPositiveVote());
    }
}
