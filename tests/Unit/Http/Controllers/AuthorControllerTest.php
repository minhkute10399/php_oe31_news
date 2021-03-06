<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Http\Controllers\AuthorController;
use App\Http\Requests\AuthorRequest;
use App\Models\Category;
use App\Models\RequestWriter;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\RequestWriter\RequestWriterRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Mockery as m;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthorControllerTest extends TestCase
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
        $this->userRepo = m::mock(UserRepositoryInterface::class)->makePartial();
        $this->postRepo = m::mock(PostRepositoryInterface::class)->makePartial();
        $this->requestWriterRepo = m::mock(RequestWriterRepositoryInterface::class)->makePartial();
        $this->authorController = new AuthorController($this->categoryRepo, $this->userRepo, $this->postRepo, $this->requestWriterRepo);
    }

    public function tearDown() : void
    {
        m::close();
        unset($this->authorController);

        parent::tearDown();
    }

    public function test_manageAuthor_load()
    {
        $categories = factory(Category::class)->make([
            'parent_id' => 0,
        ]);
        $authors = factory(User::class)->make([
            'role_id' => 2,
        ]);
        $this->categoryRepo->shouldReceive('loadParent')
            ->once()
            ->andReturn($categories);
        $this->userRepo->shouldReceive('loadAuthor')
            ->once()
            ->andReturn($authors);
        $result = $this->authorController->manageAuthor();
        $this->assertEquals('website.backend.author_request.index', $result->getName());
        $this->assertArrayHasKey('category', $result->getData());
        $this->assertArrayHasKey('requestWriter', $result->getData());
    }

    public function test_create_post_unauthorized()
    {
        $user = factory(User::class)->make([
            'role_id' => 3,
        ]);
        $this->be($user);
        $this->expectException(HttpException::class);
        $this->authorController->create();
    }

    public function test_create_post_authorized()
    {
        $category = factory(Category::class, 5)->make();
        $author = factory(User::class)->make([
            'role_id' => 2,
        ]);
        $this->be($author);
        $this->categoryRepo->shouldReceive('loadParent')
            ->once()
            ->andReturn($category);
        $result = $this->authorController->create();
        $this->assertEquals('website.frontend.create', $result->getName());
        $this->assertArrayHasKey('category', $result->getData());
    }

    public function test_postAuthor_unauthorize()
    {
        $id = 1;
        $user = factory(User::class)->make([
            'role_id' => 3,
        ]);
        $this->be($user);
        $this->expectException(HttpException::class);
        $this->authorController->postAuthor($id);
    }

    public function test_postAuthor_authorize()
    {
        $id = 10;
        $author = factory(User::class)->make([
            'role_id' => 2,
        ]);
        $groupAuthor = factory(User::class, 5)->make([
            'role_id' => 2,
        ]);
        $categoriesParent = factory(Category::class, 5)->make([
            'parent_id' => 0,
        ]);
        $this->be($author);
        $this->userRepo->shouldReceive('loadMyPost')
            ->with($id)
            ->once()
            ->andReturn($groupAuthor);
        $this->categoryRepo->shouldReceive('loadParent')
            ->once()
            ->andReturn($categoriesParent);
        $result = $this->authorController->postAuthor($id);
        $this->assertEquals('website.frontend.authors', $result->getName());
        $this->assertArrayHasKey('users', $result->getData());
        $this->assertArrayHasKey('category', $result->getData());
    }

    public function test_store_image()
    {
        $request = new Request;
        $result = $this->authorController->store($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_store_image_has_image()
    {
        $post = factory(Post::class)->make();
        $requestA = new Request;
        $requestA->files = new FileBag([
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $this->postRepo->shouldReceive('create')
            ->once()
            ->andReturn($post);
        $result = $this->authorController->store($requestA);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_requestAuthor_cannot_become_author()
    {
        $request = new Request;
        $user = factory(User::class)->make([
            'role_id' => 2,
        ]);
        $this->be($user);
        $writerRequest = factory(RequestWriter::class)->make();
        $user->setRelation('requestwriter', $writerRequest);
        $this->expectException(HttpException::class);
        $result = $this->authorController->requestAuthor($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_requestAuthor_can_become_author()
    {
        $requestWriter = factory(RequestWriter::class);
        $elseWriter = factory(RequestWriter::class, 1)->make([
            'note' => 'test',
            'user_id' => 5,
        ]);
        $request = new Request;
        $user = factory(User::class)->make([
            'id' => 5,
            'role_id' => 3,
        ]);
        $this->be($user);
        $user->setRelation('requestwriter', $requestWriter);
        $this->requestWriterRepo->shouldReceive('create')
            ->once()
            ->andReturn($elseWriter);
        $result = $this->authorController->requestAuthor($request);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_edit_view_blade_fail_find()
    {
        $id = 100;
        $this->postRepo->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn(null)
            ->andThrow(new HttpException(404));
        $this->expectException(HttpException::class);
        $this->authorController->edit($id);
    }

    public function test_edit_view_blade_find_true()
    {
        $id = 100;
        $post = factory(Post::class)->make();
        $categoryParent = factory(Category::class)->make([
            'parent_id' => 0,
        ]);
        $childrenCate = factory(Category::class, 5)->make([
            'parent_id' => 1
        ]);
        $categoryParent->setRelation('children', $childrenCate);
        $this->postRepo->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn($post);
        $this->categoryRepo->shouldReceive('loadParent')
            ->once()
            ->andReturn($categoryParent);
        $result = $this->authorController->edit($id);
        $this->assertEquals('website.frontend.edit', $result->getName());
        $this->assertArrayHasKey('authors', $result->getData());
        $this->assertArrayHasKey('category', $result->getData());
    }

    public function test_update_find_fail_id()
    {
        $id = 100;
        $request = new Request;
        $post = factory(Post::class)->make();
        $this->postRepo->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn(false)
            ->andThrow(new HttpException(404));
        $this->expectException(HttpException::class);
        $this->authorController->update($request, $id);
    }

    public function test_update_find_true_id_has_no_file()
    {
        $id = 100;
        $request = new Request;
        $post = factory(Post::class)->make();
        $this->postRepo->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn($post);
        $result = $this->authorController->update($request, $id);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_update_find_true_id_has_file()
    {
        $id = 100;
        $request = new Request;
        $post = factory(Post::class)->make();
        $this->postRepo->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn($post);
        $image = $request->files = new FileBag([
            'image' => UploadedFile::fake()->image('test.jpg'),
        ]);
        $data = [
            'title' => 'test',
            'content' => 'test abc',
            'category_id' => 0,
            'view' => 1,
            'user_id' => 5,
            'image'=> $image,
            'status' => 1,
        ];
        $this->postRepo->shouldReceive('update')
            ->once()
            ->andReturn($data);
        $result = $this->authorController->update($request, $id);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_destroy_fail_id()
    {
        $id = 10;
        $this->postRepo->shouldReceive('delete')
            ->with($id)
            ->once()
            ->andReturn(false)
            ->andThrow(new HttpException(404));
        $this->expectException(HttpException::class);
        $this->authorController->destroy($id);
    }

    public function test_destroy_find_true_id()
    {
        $id = 10;
        $post = factory(Post::class)->make([
            'status' => 1,
        ]);
        $this->postRepo->shouldReceive('delete')
            ->with($id)
            ->once()
            ->andReturn($post);
        $result = $this->authorController->destroy($id);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
