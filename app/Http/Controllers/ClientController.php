<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Like;
use App\Models\Post;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Like\LikeRepository;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    protected $categoryRepo;
    protected $postRepo;
    protected $likeRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo,
        PostRepositoryInterface $postRepo,
        LikeRepositoryInterface $likeRepo
    ) {
        $this->categoryRepo = $categoryRepo;
        $this->postRepo = $postRepo;
        $this->likeRepo = $likeRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = $this->categoryRepo->loadParent();
        $posts = $this->postRepo->showApprovedPost();

        return view('website.frontend.index', compact('posts', 'category'));
    }

    public function filterCategory($id)
    {
        $category = $this->categoryRepo->filterCategory($id);
        $posts = $this->postRepo->takePostBaseOnCategory($id);
        $allCategory = $this->categoryRepo->loadParent();

        return view('website.frontend.filter_category', compact('posts', 'allCategory', 'category'));
    }

    public function postLike(Request $request)
    {
        $data = $request->all();
        $postId = $request['post_id'];
        $post = $this->postRepo->find($postId);
        if (!$post) {

            return null;
        }
        $like = $this->likeRepo->queryLike($postId);
        if(!$like) {
            $like = $this->likeRepo->create([
                'user_id' => Auth::id(),
                'post_id' => $postId,
                'like' => config('number_format.like'),
            ]);
        }
        else {
            $like->delete();
        }

        return response()->json([
            'status' => true
        ]);
    }
}
