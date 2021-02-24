<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CountPost extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $totalPendingPost;
    protected $totalApprovedPost;
    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.countPost')
            ->with([
                'user' => $this->user,
                'totalPendingPost' => $this->totalPendingPost,
                'totalApprovedPost' => $this->totalApprovedPost,
        ]);
    }
}
