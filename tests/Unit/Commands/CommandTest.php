<?php

namespace Tests\Unit\Commands;

use Tests\TestCase;
use Mockery as m;
use App\Repositories\User\UserRepositoryInterface;
use App\Console\Commands\MailShowAuthorPost;
use App\Jobs\ProcessMail;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;

class CommandTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->make([
            'role_id' => 2,
        ]);
        $totalApprovedPost = 2;
        $totalPendingPost = 2;
        $this->job = new ProcessMail($this->user, $totalApprovedPost, $totalPendingPost);
        $this->userRepo = m::mock(UserRepositoryInterface::class)->makePartial();
        $this->command = new MailShowAuthorPost($this->userRepo);
    }

    public function tearDown() :void
    {
        unset($this->userRepo);
        unset($this->command);
        unset($this->job);
        unset($this->user);

        parent::tearDown();
    }

    public function test_handle_function()
    {
        Bus::fake();
        $month = Carbon::now()->month;
        $authors = factory(User::class)->make([
            'status' => 2,
        ]);
        $authors->posts_pending = 1;
        $authors->posts_approve = 2;
        $this->userRepo->shouldReceive('takeAuthorAndPost')
            ->with($month)
            ->once()
            ->andReturn([$authors]);
        $this->command->handle();
        Bus::assertDispatched(ProcessMail::class, 1);
    }
}
