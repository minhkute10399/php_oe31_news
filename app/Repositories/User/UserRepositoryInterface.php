<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    /**
     * show List all user in admin page.
     *
     * @param  null
     *
     * @return $user
     */
    public function listUser();

    /**
     * Load all post of that author.
     *
     * @param  null
     *
     * @return $post
     */
    public function loadAuthor();

    /**
     * Load all post of that author.
     *
     * @param  null
     *
     * @return $post
     */
    public function loadMyPost($id);
}
