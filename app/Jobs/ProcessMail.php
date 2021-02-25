<?php

namespace App\Jobs;

use App\Mail\CountPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Mail;

class ProcessMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $totalPendingPost;
    protected $totalApprovedPost;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $totalApprovedPost, $totalPendingPost)
    {
        $this->user = $user;
        $this->totalApprovedPost = $totalApprovedPost;
        $this->totalPendingPost = $totalPendingPost;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new CountPost($this->user, $this->totalApprovedPost, $this->totalPendingPost));
    }
}
