<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\ProcessMail;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

class MailShowAuthorPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:remind';
    protected $userRepo;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show post with full status for author on every months on day 30 at 8 hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        parent::__construct();
        $this->userRepo = $userRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $month = Carbon::now()->month;
        $author = $this->userRepo->takeAuthorAndPost($month);

        foreach ($author as $user) {
            $totalPendingPost = $user->posts_pending;
            $totalApprovedPost = $user->posts_approve;
            ProcessMail::dispatch($user, $totalApprovedPost, $totalPendingPost);
        }
    }
}
