<?php
namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function loadParent()
    {
        return $this->model->where('parent_id', config('number_format.parent_id'))->with('children')->get();
    }

    public function getCategoryIndex()
    {
        return $this->model->where('parent_id', config('number_format.parent_id'))->paginate(config('number_status_post.paginate_home'));
    }

    public function getCategoryCreate()
    {
        return $this->model->where('parent_id', config('number_format.parent_id'))->get();
    }

}
