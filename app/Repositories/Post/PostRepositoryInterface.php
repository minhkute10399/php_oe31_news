<?php
namespace App\Repositories\Post;

interface PostRepositoryInterface
{
    /**
     * Update frequency score attribute of the records of the current week.
     *
     * @param  null
     *
     * @return $post which status = 1
     */
    public function getPendingPost();

    /**
     * Search function is defined for searching title of the accepted post.
     *
     * @param  $search
     *
     * @return $post
     */
    public function search($search);

    /**
     * Search function is defined for searching title of the accepted post.
     *
     * @param  $search
     *
     * @return $post
     */
    public function showRequestPost();
}
