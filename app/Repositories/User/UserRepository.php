<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function listUser()
    {
        return $this->model->paginate(config('paginate.page'));
    }

    public function loadAuthor()
    {
        return $this->model->where('role_id', config('number_status_post.author'))->get();
    }

    public function loadMyPost($id)
    {
        return $this->model->findOrFail($id)->load(['posts' => function ($query) {
            $query->where('status', config('number_status_post.status_request'));
        }]);
    }

    public function takeAuthorAndPost($month)
    {
        return $this->model->where('role_id', config('number_status_post.author'))->withCount([
            'posts as posts_pending' => function ($query) use ($month) {
                return $query->whereMonth('created_at', '=', $month)
                    ->where('status', config('number_status_post.pending'));
            }
        ])
        ->withCount([
            'posts as posts_approve' => function ($query) use ($month) {
                return $query->whereMonth('created_at', '=', $month)
                    ->where('status', config('number_status_post.status'));
            }
        ])->get();
    }
}
