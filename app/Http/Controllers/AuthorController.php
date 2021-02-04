<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\RequestWriter;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function manageAuthor()
    {
        $category = Category::where('parent_id', config('number_format.parent_id'))->get();
        $category->load('children');
        $requestWriter = User::where('role_id', config('number_status_post.author'))->get();

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
        $category = Category::all();
        $category->load('children');

        return view('website.frontend.create', compact('category'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function postAuthor($id)
    {
        if (!Gate::allows('my_post')) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $users = User::findOrFail($id)->load(['posts' => function ($query) {
            $query->where('status', config('number_status_post.status_request'));
        }]);
        $category = Category::where('parent_id', config('number_format.parent_id'))->get();
        $category->load('children');

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
            Post::create([
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
            RequestWriter::create([
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
        $authors = Post::findOrFail($id);
        $category = Category::all();
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
        $authors = Post::findOrFail($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move(public_path(config('image_user.image')), $fileName);
            $authors->update([
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
            Alert::error(trans('message.success'), trans('messsage.add_successfully'));
        }

        return redirect()->route('authors.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Post::destroy($id);

        return redirect()->back();
    }
}
