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
     * This function show all post which is pending.
     *
     * @param  null
     *
     * @return $post
     */
    public function showRequestPost();

    /**
     * This function show all post which is approved.
     *
     * @param  null
     *
     * @return $post
     */
    public function showApprovedPost();

    /**
     * This function show all post which is same category.
     *
     * @param  null
     *
     * @return $post
     */
    public function takePostBaseOnCategory($id);

     /**
     * This function take post which is approved and soft base on month.
     *
     * @param  null
     *
     * @return $post
     */
    public function takePostBaseOnMonth();
}
