<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Repositories\Admin;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;

class AdminController extends Controller
{
    protected $postRepo;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->middleware('auth');
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        return view('website.backend.layouts.main');
    }

    public function showRequestPost()
    {
        $posts = $this->postRepo->showRequestPost();

        return view('website.backend.post.pending_request', compact('posts'));
    }

    public function previewPost($id)
    {
        $post = $this->postRepo->find($id);

        return view('website.frontend.preview_post', compact('post'));
    }
}
