<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\ClientController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Like;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Like\LikeRepository;
use App\Repositories\Like\LikeRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Tests\TestCase;
use Mockery as m;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ClientControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->categoryRepo = m::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->postRepo = m::mock(PostRepositoryInterface::class)->makePartial();
        $this->likeRepo = m::mock(LikeRepositoryInterface::class)->makePartial();
        $this->clientController = new ClientController($this->categoryRepo, $this->postRepo, $this->likeRepo);
    }

    public function tearDown() : void
    {
        m::close();
        unset($this->clientController);

        parent::tearDown();
    }

    public function test_index_view()
    {
        $categoryParent = factory(Category::class)->make([
            'parent_id' => 0,
        ]);
        $postApproved = factory(Post::class)->make([
            'status' => 2,
        ]);
        $this->categoryRepo->shouldReceive('loadParent')
            ->once()
            ->andReturn($categoryParent);
        $this->postRepo->shouldReceive('showApprovedPost')
            ->once()
            ->andReturn($postApproved);
        $result = $this->clientController->index();
        $this->assertEquals('website.frontend.index', $result->getName());
        $this->assertArrayHasKey('posts', $result->getData());
        $this->assertArrayHasKey('category', $result->getData());
    }

    public function test_filterCategory()
    {
        $id = 1;
        $categoryParent = factory(Category::class, 4)->make([
            'parent_id' => 0,
        ]);
        $postApproved = factory(Post::class, 4)->make([
            'status' => 2,
        ]);
        $this->categoryRepo->shouldReceive('filterCategory')
            ->with($id)
            ->once()
            ->andReturn($categoryParent);
        $this->postRepo->shouldReceive('takePostBaseOnCategory')
            ->with($id)
            ->once()
            ->andReturn($postApproved);
        $this->categoryRepo->shouldReceive('loadParent')
            ->once()
            ->andReturn($categoryParent);
        $result = $this->clientController->filterCategory($id);
        $this->assertEquals('website.frontend.filter_category', $result->getname());
        $this->assertArrayHasKey('posts', $result->getData());
        $this->assertArrayHasKey('allCategory', $result->getData());
        $this->assertArrayHasKey('category', $result->getData());
    }

    public function test_like_find_post_fail()
    {
        $request = new Request;
        $postId = $request['post_id'];
        $this->postRepo->shouldReceive('find')
            ->with($postId)
            ->once()
            ->andReturn(null);
        $result = $this->clientController->postLike($request);
        $this->assertNull($result);
    }

    public function test_like_post_true_and_fail_queryLike()
    {
        $post = factory(Post::class)->make([
            'post_id' => 20,
        ]);
        $request = new Request;
        $postId = $request['post_id'];
        $like = factory(Like::class)->make([
            'user_id' => 4,
            'post_id' => $postId,
            'like' => 1,
        ]);
        $this->postRepo->shouldReceive('find')
            ->with($postId)
            ->once()
            ->andReturn($post);
        $this->likeRepo->shouldReceive('queryLike')
            ->with($postId)
            ->once()
            ->andReturn(false);
        $this->likeRepo->shouldReceive('create')
            ->once()
            ->andReturn($like);
        $result = $this->clientController->postLike($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(200, $result->status());
    }

    public function test_like_post_true_and_true_queryLike()
    {
        $post = factory(Post::class)->make([
            'post_id' => 20,
        ]);
        $request = new Request;
        $id = $request['id'];
        $postId = $request['post_id'];
        $like = factory(Like::class)->make([
            'user_id' => 4,
            'post_id' => $postId,
            'like' => 1,
        ]);
        $this->postRepo->shouldReceive('find')
            ->with($postId)
            ->once()
            ->andReturn($post);
        $this->likeRepo->shouldReceive('queryLike')
            ->with($postId)
            ->once()
            ->andReturn($like);
        $this->likeRepo->shouldReceive('delete')
            ->with($like->id)
            ->once()
            ->andReturn(true);
        $result = $this->clientController->postLike($request);
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals(200, $result->status());
    }
}
