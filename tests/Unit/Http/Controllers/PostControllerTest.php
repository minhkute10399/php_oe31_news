<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\PostController;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Http\RedirectResponse;
use Mockery as m;
use App\Models\Post;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostRepository;
use Facade\FlareClient\Http\Response;
use Facebook\WebDriver\Exception\ExpectedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostControllerTest extends TestCase
{
    protected $postRepo;
    protected $categoryRepo;
    protected $postControllerTest;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent ::setUp();

        $this->postRepo = m::mock(PostRepositoryInterface::class)->makePartial();
        $this->categoryRepo = m::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->postControllerTest = new PostController($this->postRepo, $this->categoryRepo);
    }

    public function test_index_view_post_admin()
    {
        $post = factory(Post::class, 10)->make([
            'status' => 2,
        ]);
        $this->postRepo
            ->shouldReceive('getPendingPost')
            ->once()
            ->andReturn($post);
        $postApproved = $this->postControllerTest->index();
        $this->assertEquals('website.backend.post.index', $postApproved->getName());
        $this->assertArrayHasKey('posts', $postApproved->getData());
    }

    public function test_find_id_show_post()
    {
        $id = 1000;
        $this->postRepo
            ->shouldReceive('find')
            ->with($id, ['comments.user'])
            ->once()
            ->andReturn(null);
        $this->expectException(HttpException::class);
        $this->postControllerTest->show($id);
    }

    public function test_show_false_status_post_admin()
    {
        $id = rand();
        $post = factory(Post::class)->make([
            'status' => 1,
        ]);
        $this->postRepo
            ->shouldReceive('find')
            ->with($id, ['comments.user'])
            ->once()
            ->andReturn($post);
        $this->expectException(HttpException::class);
        $this->postControllerTest->show($id);
    }

    public function test_show_true_status_post_admin()
    {
        $id = rand();
        $request = new Request();
        $post = factory(Post::class)->make([
            'status' => 2,
        ]);
        $category = factory(Category::class, 10)->make();
        $this->postRepo
            ->shouldReceive('find')
            ->with($id, ['comments.user'])
            ->once()
            ->andReturn($post);
        $this->categoryRepo
            ->shouldReceive('loadParent')
            ->once()
            ->andReturn($category);
        $this->postRepo
            ->shouldReceive('update')
            ->with($id, [
                'view' => $post->view + 1,
            ])
            ->once()
            ->andReturn(true);
        $showPostTrue = $this->postControllerTest->show($id);
        $this->assertEquals('website.frontend.detail', $showPostTrue->getName());
        $this->assertArrayHasKey('post', $showPostTrue->getData());
        $this->assertArrayHasKey('category', $showPostTrue->getData());
    }

    public function test_search_home()
    {
        $request = new Request();
        $search = $request->search;
        $category = factory(Category::class, 10)->make();
        $post = factory(Post::class)->make([
            'status' => 2,
        ]);
        $this->categoryRepo
            ->shouldReceive('loadParent')
            ->once()
            ->andReturn($category);
        $this->postRepo
            ->shouldReceive('search')
            ->with($search)
            ->once()
            ->andReturn($post);
        $searchHome = $this->postControllerTest->search($request);
        $this->assertEquals('website.frontend.search', $searchHome->getName());
        $this->assertArrayHasKey('posts', $searchHome->getData());
        $this->assertArrayHasKey('category', $searchHome->getData());
        $this->assertArrayHasKey('search', $searchHome->getData());
    }

    public function test_update_status_block()
    {
        $id = rand();
        $request = new Request();
        $post = factory(Post::class)->make([
            'status' => 2,
        ]);
        $this->postRepo
            ->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn($post);
        $this->postRepo
            ->shouldReceive('update')
            ->with($id, ['status' => $request->status])
            ->once()
            ->andReturn($post);
        $updateBlockStatus = $this->postControllerTest->update($request, $id);
        $this->assertInstanceOf(RedirectResponse::class, $updateBlockStatus);
    }

    public function test_update_status_accept()
    {
        $id = rand();
        $request = new Request();
        $post = factory(Post::class)->make([
            'status' => 1,
        ]);
        $this->postRepo
            ->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn($post);
        $this->postRepo
            ->shouldReceive('update')
            ->with($id, ['status' => $request->status])
            ->once()
            ->andReturn($post);
        $updateBlockStatus = $this->postControllerTest->update($request, $id);
        $this->assertInstanceOf(RedirectResponse::class, $updateBlockStatus);
    }

    public function tearDown() : void
    {
        m::close();
        unset($this->postControllerTest);

        parent::tearDown();
    }
}
