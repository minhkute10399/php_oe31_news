<?php

namespace Tests\Unit\Events;

use App\Events\CommentNotification;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentEventTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->channel = [
            'id' => 4,
            'title' => 'New Comment',
            'content' => 'You have a new comment on your post',
            'post_id' => 29,
        ];
        $this->event = new CommentNotification($this->channel);
    }

    public function tearDown() : void
    {
        unset($this->channel);
        unset($this->event);
        parent::tearDown();
    }

    public function test_broadcastOn()
    {
        Event::fake();
        $result = $this->event->broadcastOn();
        $this->assertEquals('private-comment-channel' . $this->channel['id'], $result);
    }
}
