<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\RequestWriter;
use App\Models\User;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\RequestWriter\RequestWriterRepository;
use App\Repositories\RequestWriter\RequestWriterRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthorController extends Controller
{
    protected $categoryRepo;
    protected $userRepo;
    protected $postRepo;
    protected $requestWriterRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo,
        UserRepositoryInterface $userRepo,
        PostRepositoryInterface $postRepo,
        RequestWriterRepositoryInterface $requestWriterRepo
    ) {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
        $this->categoryRepo = $categoryRepo;
        $this->postRepo = $postRepo;
        $this->requestWriterRepo = $requestWriterRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function manageAuthor()
    {
        $category = $this->categoryRepo->loadParent();
        $requestWriter = $this->userRepo->loadAuthor();

        return view('website.backend.author_request.index', compact('category', 'requestWriter'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('create_post')) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $category = $this->categoryRepo->getAll();
        $category->load('children');

        return view('website.frontend.create', compact('category'));
    }

    public function postAuthor($id)
    {
        if (!Gate::allows('my_post')) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $users = $this->userRepo->loadMyPost($id);
        $category = $this->categoryRepo->loadParent();

        return view ('website.frontend.authors', compact('users', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move(public_path(config('image_user.image')), $fileName);
            $this->postRepo->create([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'view' => config('number_status_post.view'),
                'user_id' => Auth::id(),
                'image'=> $fileName,
                'status' => config('number_status_post.status_request'),
            ]);
            Alert::success(trans('message.success'), trans('messsage.successfully'));

            return redirect()->route('home.index');
        }

        return redirect()->route('home.index');
    }

    public function requestAuthor(Request $request)
    {
        if (!Gate::denies('become_author')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        if (is_null(Auth::user()->load('requestwriter')->requestwriter)) {
            $this->requestWriterRepo->create([
                'note' => $request->note,
                'user_id' => Auth::id(),
            ]);
            toast(trans('message.successfully'),'success')->timerProgressBar();
        } else {
            toast(trans('message.spamrequest'),'warning')->timerProgressBar();
        }

        return redirect()->back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authors = $this->postRepo->find($id);
        $category = $this->categoryRepo->getAll();
        $category->load('children');

        return view('website.frontend.edit', compact('authors', 'category'));
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
        $authors = $this->postRepo->find($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move(public_path(config('image_user.image')), $fileName);
            $this->postRepo->update($id, [
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'view' => config('number_status_post.view'),
                'user_id' => Auth::id(),
                'image'=> $fileName,
                'status' => config('number_status_post.view'),
            ]);
            Alert::success(trans('message.success'), trans('messsage.successfully'));
            return redirect()->route('home.index');
        } else {
            Alert::error(trans('message.success'), trans('messsage.successfully'));

            return redirect()->route('home.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepo->delete($id);

        return redirect()->back();
    }
}
