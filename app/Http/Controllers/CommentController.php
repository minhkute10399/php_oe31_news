<?php

namespace App\Http\Controllers;

use App\Events\CommentNotification;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CommentNoti;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }
    public function index(Post $post)
    {
        return response()->json($post->comments()->with('user')->latest()->get());
    }

    public function store(Request $request)
    {
        $post = Post::find($request->post_id);
        $data = [
            'message' => trans("message.error"),
        ];
        $channel = [
            'id' => $request->channel_author_id,
            'title' => trans('message.title_notify'),
            'content' => trans('message.content_notify'),
            'post_id' => route('posts.show', [$request->post_id]),
        ];
        $authorId = $request->channel_author_id;
        $findAuthor = $this->userRepo->find($authorId);
        $findAuthor->notify(new CommentNoti($channel));
        event(new CommentNotification($channel));
        if (empty($post)) {
            return json_encode($data);
        }
        $check = Comment::create([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
        ]);
        if ($check) {
            $data['message'] = trans("message.success");
            $data['content'] = $request->content;
            $data['username'] = Auth::user()->name;
            $data['image'] = Auth::user()->image;
            $data['created_at'] = $check->created_at;

            return view ('website.frontend.ajax_comment', compact('data', 'channel'));
        }

        return response()->json([
            'data' => $data,
            'channel' => $channel,
        ]);
    }

    public function currentUser()
    {
        return response()->json([
            'id' => Auth::id(),
        ]);
    }
}
