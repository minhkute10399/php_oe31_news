<?php
namespace App\Repositories\Post;

use App\Repositories\BaseRepository;
use App\Models\Post;
use Carbon\Carbon;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{

    public function getModel()
    {
        return Post::class;
    }

    public function getPendingPost()
    {
        return $this->model
            ->with('author')
            ->where('status', config('number_status_post.status'))
            ->latest()
            ->paginate(config('number_status_post.paginate_home'));
    }

    public function search($search)
    {
        return $this->model
            ->where('title', 'LIKE', '%' .$search. '%')
            ->with('category')
            ->paginate(config('number_status_post.paginate_home'));
    }

    public function showRequestPost()
    {
        return $this->model
            ->where('status', config('number_status_post.status_request'))
            ->latest()
            ->paginate(config('number_status_post.paginate_home'));
    }

    public function showApprovedPost()
    {
        return $this->model
            ->where('status', config('number_status_post.status'))
            ->latest()
            ->paginate(config('number_status_post.paginate_home'));
    }

    public function takePostBaseOnCategory($id)
    {
        return $this->model->where('category_id', $id)
            ->with('category')->latest()
            ->paginate(config('number_status_post.paginate_home'));
    }

    public function takePostBaseOnMonth()
    {
        return $this->model->where('status', config('number_status_post.status'))
            ->get()
            ->groupBy(function ($query) {
                return Carbon::parse($query->updated_at)->format('m');
        });
    }
}
