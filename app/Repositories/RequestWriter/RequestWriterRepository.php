<?php
namespace App\Repositories\RequestWriter;

use App\Repositories\BaseRepository;
use App\Models\RequestWriter;

class RequestWriterRepository extends BaseRepository implements RequestWriterRepositoryInterface
{
    public function getModel()
    {
        return RequestWriter::class;
    }

    public function showRequestWriter()
    {
        return $this->model->with('author')
            ->latest()
            ->paginate(config('number_status_post.paginate_home'));
    }
}
