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
}
