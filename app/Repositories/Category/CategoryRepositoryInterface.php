<?php
namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getCategoryIndex();

    public function getCategoryCreate();

    public function loadParent();

    public function filterCategory($id);
}
