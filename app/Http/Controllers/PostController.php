<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\Response;
use App\Models\Category;
use App\Models\User;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\CategoryRepository;

class PostController extends Controller
{
    protected $postRepo;
    protected $categoryRepo;

    public function __construct(PostRepositoryInterface $postRepo, CategoryRepositoryInterface $categoryRepo)
    {
        $this->middleware('admin')->except(['show', 'search']);
        $this->middleware('auth')->except('show');
        $this->postRepo = $postRepo;
        $this->categoryRepo = $categoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepo->getPendingPost();

        return view('website.backend.post.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postRepo->find($id, ['comments.user']);
        if (!$post || $post->status == config('number_status_post.status_request')) {
            abort(Response::HTTP_NOT_FOUND);
        }
        $category = $this->categoryRepo->loadParent();
        $this->postRepo->update($id, [
            'view' => $post->view + config('number_format.view'),
        ]);

        return view('website.frontend.detail', compact('post', 'category'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $category = $this->categoryRepo->loadParent();
        $posts = $this->postRepo->search($search);

        return view('website.frontend.search', compact('posts', 'category', 'search'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = $this->postRepo->find($id);
        $this->postRepo->update($id, [
            'status' => $request->status,
        ]);
        Alert::success(trans('message.success'), trans('message.successfully'));

        return redirect()->back();
    }
}
