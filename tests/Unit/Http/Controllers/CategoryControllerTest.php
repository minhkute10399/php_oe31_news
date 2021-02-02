<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CategoryController;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Mockery as m;
use Illuminate\Http\Request;
use Facade\FlareClient\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected $categoryController;
    protected $categoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->categoryRepo = m::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->categoryController = new CategoryController($this->categoryRepo);
    }

    public function tearDown() : void
    {
        m::close();
        unset($this->categoryController);
        parent::tearDown();
    }

    public function test_function_index()
    {
        $this->categoryRepo->shouldReceive('getCategoryIndex')->andReturn(true);
        $result = $this->categoryController->index();
        $this->assertEquals('website.backend.category.index', $result->getName());
        $this->assertArrayHasKey('items', $result->getData());
    }

    public function test_function_create()
    {
        $this->categoryRepo->shouldReceive('getCategoryCreate')->andReturn(true);
        $result = $this->categoryController->create();
        $this->assertEquals('website.backend.category.create', $result->getName());
        $this->assertArrayHasKey('categories', $result->getData());
    }

    public function test_function_store()
    {
        $url = route('categories.index');
        $request = new Request;
        $category = factory(Category::class, 10)->make();
        $this->categoryRepo
             ->shouldReceive('create')
             ->once()
             ->andReturn($category);
        $cateStore = $this->categoryController->store($request);
        $this->assertEquals($url, $cateStore->getTargetUrl());
    }

    public function test_function_show_fail()
    {
        $id = rand();
        $category = factory(Category::class)->make([
            'parent_id' => 1,
        ]);
        $this->categoryRepo
             ->shouldReceive('find')
             ->with($id, ['children'])
             ->once()
             ->andReturn($category);
        $this->expectException(HttpException::class);
        $this->categoryController->show($id);
    }

    public function test_function_show_true()
    {
        $id = rand();
        $category = factory(Category::class)->make();
        $this->categoryRepo
             ->shouldReceive('find')
             ->with($id, ['children'])
             ->once()
             ->andReturn($category);
        $showtrue = $this->categoryController->show($id);
        $this->assertEquals('website.backend.category.show', $showtrue->getName());
        $this->assertArrayHasKey('category', $showtrue->getData());
    }

    public function test_function_edit_true()
    {
        $id = rand();
        $category = factory(Category::class)->make();
        $this->categoryRepo
             ->shouldReceive('find')
             ->with($id, ['children'])
             ->once()
             ->andReturn($category);
        $this->categoryRepo
             ->shouldReceive('getAll')
             ->once()
             ->andReturn($category);
        $cateEdit = $this->categoryController->edit($id);
        $this->assertEquals('website.backend.category.update', $cateEdit->getName());
        $this->assertArrayHasKey('category', $cateEdit->getData());
        $this->assertArrayHasKey('categoryList', $cateEdit->getData());
    }

    public function test_function_update()
    {
        $id = rand();
        $url = route('categories.index');
        $request = new Request;
        $category = factory(Category::class)->make([
            'parent_id' => 0,
        ]);
        $this->categoryRepo
             ->shouldReceive('find')
             ->with($id)
             ->once()
             ->andReturn($category);
        $this->categoryRepo
             ->shouldReceive('update')
             ->with($id, ['name' => $request->name, 'parent_id' => $request->parent_id])
             ->once()
             ->andReturn($category);
        $cateUpdate = $this->categoryController->update($request, $id);
        $this->assertEquals($url, $cateUpdate->getTargetUrl());
    }

    public function test_function_destroy()
    {
        $id = rand();
        $category = factory(Category::class)->make();
        $this->categoryRepo
             ->shouldReceive('find')
             ->with($id, ['children'])
             ->once()
             ->andReturn($category);
        $this->categoryRepo
             ->shouldReceive('delete')
             ->with($id)
             ->once()
             ->andReturn($category);
        $cateDestroy = $this->categoryController->destroy($id);
        $this->assertInstanceOf(RedirectResponse::class, $cateDestroy);
    }

    public function test_function_destroy_has_children()
    {
        $id = rand();
        $category = factory(Category::class)->make([
            'id' => 100,
        ]);
        $child = factory(Category::class, 3)->make([
            'parent_id' => $category->id,
        ]);
        $category->setRelation('children', $child);
        $this->categoryRepo
             ->shouldReceive('find')
             ->with($id, ['children'])
             ->once()
             ->andReturn($category);
        $this->categoryRepo
             ->shouldReceive('delete')
             ->with($id)
             ->once()
             ->andReturn($category);
        $cateDestroy = $this->categoryController->destroy($id);
        $this->assertInstanceOf(RedirectResponse::class, $cateDestroy);
    }
}
