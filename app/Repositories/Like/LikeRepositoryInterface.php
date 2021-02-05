<?php
namespace App\Repositories\Like;

interface LikeRepositoryInterface
{
    /**
     * show List all requestWriter in admin page.
     *
     * @param  null
     *
     * @return $requestWriter
     */
    public function queryLike($postId);
}
