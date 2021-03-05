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
        $result = $this->mail->build();
        $this->assertInstanceOf(CountPost::class, $result);
        $this->assertEquals($this->user, $result->viewData['user']);
        $this->assertEquals($this->totalPendingPost, $result->viewData['totalPendingPost']);
        $this->assertEquals($this->totalApprovedPost, $result->viewData['totalApprovedPost']);
    }
}
