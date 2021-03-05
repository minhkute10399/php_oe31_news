<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Middleware\Admin;
use App\Models\Post;
use App\Repositories\Post\PostRepositoryInterface;
use App\Http\Controllers\AdminController;
use Carbon\Carbon;
use Mockery as m;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->postRepo = m::mock(PostRepositoryInterface::class)->makePartial();
        $this->adminController = new AdminController($this->postRepo);
    }

    public function tearDown() : void
    {
        unset($this->postRepo);
        unset($this->adminController);
        parent::tearDown();
    }

    public function test_index_admin()
    {
        $result = $this->adminController->index();
        $this->assertEquals('website.backend.layouts.chart', $result->getName());
    }

    public function test_show_request_post()
    {
        $posts = factory(Post::class)->make([
            'status' => 1,
        ]);
        $this->postRepo->shouldReceive('showRequestPost')
            ->once()
            ->andReturn($posts);
        $result = $this->adminController->showRequestPost();
        $this->assertEquals('website.backend.post.pending_request', $result->getName());
        $this->assertArrayHasKey('posts', $result->getData());
    }

    public function test_update_chart()
    {
        $posts = factory(Post::class, 10)->make([
            'status' => 2,
            'created_at' => Carbon::now()->month,
        ]);
        $this->postRepo->shouldReceive('takePostBaseOnMonth')
            ->once()
            ->andReturn($posts->groupBy(function ($query) {
                return Carbon::parse($query->updated_at)->format('m');
            }));
        $result = $this->adminController->updateChart();
        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertEquals('{"posts":{"03":10}}', $result->getContent());
        $this->assertEquals(200, $result->status());
    }
}
