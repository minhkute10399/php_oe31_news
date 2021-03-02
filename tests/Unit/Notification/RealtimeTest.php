<?php

namespace Tests\Unit\Notification;

use App\Models\Post;
use App\Notifications\CommentNoti;
use App\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RealtimeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->channel = [
            'id' => 4,
            'title' => 'New Comment',
            'content' => 'You have a new comment on your post',
            'post_id' => 29,
        ];
        $this->commentNotification = new CommentNoti($this->channel);
    }

    public function tearDown(): void
    {
        unset($this->channel);
        unset($this->commentNotification);
        parent::tearDown();
    }

    public function test_via_method()
    {
        $this->assertEquals(['database'], $this->commentNotification->via($this->channel));
    }

    public function test_toArray_method()
    {
        $this->assertEquals($this->channel, $this->commentNotification->toArray($this->channel));
    }
}
