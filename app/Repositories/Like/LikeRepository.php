<?php
namespace App\Repositories\Like;

use App\Repositories\BaseRepository;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeRepository extends BaseRepository implements LikeRepositoryInterface
{
    public function getModel()
    {
        return Like::class;
    }

    public function queryLike($postId)
    {
        return $this->model->where([
            ['user_id', Auth::id()],
            ['post_id', $postId]
        ])->first();
    }
}
