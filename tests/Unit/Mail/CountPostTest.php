<?php

namespace Tests\Unit\Mail;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\CountPost;
use Tests\TestCase;

class CountPostTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->make([
            'role_id' => 2,
        ]);
        $this->totalPendingPost = 2;
        $this->totalApprovedPost = 2;
        $this->mail = new CountPost($this->user, $this->totalPendingPost, $this->totalApprovedPost);
    }

    public function tearDown(): void
    {
        unset($this->user);
        unset($this->mail);
        unset($this->totalPendingPost);
        unset($this->totalApprovedPost);

        parent::tearDown();
    }
    public function test_build_mail_send()
    {
        Mail::fake();
        Mail::send($this->mail);
        Mail::assertSent(CountPost::class, function ($mail) {
            $this->mail->build();
            $this->assertEquals($mail->viewData['user'], $this->user);
            $this->assertEquals($mail->viewData['totalPendingPost'], $this->totalPendingPost);
            $this->assertEquals($mail->viewData['totalApprovedPost'], $this->totalApprovedPost);

            return true;
        });
    }
}
