<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Auth\Access\Gate;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Response;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->middleware('auth');
        $this->categoryRepo = $categoryRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->categoryRepo->getCategoryIndex();

        return view('website.backend.category.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepo->getCategoryCreate();

        return view('website.backend.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->categoryRepo->create($request->only(['name', 'parent_id']));
        Alert::success(trans('message.success'), trans('messsage.successfully'));

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepo->find($id, ['children']);

        if ($category->parent_id != config('number_format.parent_id')) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('website.backend.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepo->find($id, ['children']);
        $categoryList = $this->categoryRepo->getAll();

        return view('website.backend.category.update', compact('category', 'categoryList'));
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
        $category = $this->categoryRepo->find($id);
        $this->categoryRepo->update($id, [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);
        Alert::success(trans('message.success'), trans('messsage.edit_successfully'));

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepo->find($id, ['children']);

        if ($category->children->count()) {
            foreach ($category->children as $child) {
                $child->delete();
            }
        }
        $this->categoryRepo->delete($id);
        Alert::success(trans('message.success'), trans('messsage.delete_successfully'));

        return redirect()->back();
    }
}
