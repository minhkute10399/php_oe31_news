<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Http\Controllers\RequestAuthorController;
use App\Models\RequestWriter;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\RequestWriter\RequestWriterRepository;
use App\Repositories\RequestWriter\RequestWriterRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use ErrorException;
use Illuminate\Http\RedirectResponse;
use Mockery as m;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RequestAuthorControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->users = factory(User::class, 5)->make([
            'role_id' => 1,
        ]);
        $this->requestWriter = factory(RequestWriter::class, 5)->make([
            'user_id' => 1,
        ]);
        $this->requestWriterRepo = m::mock(RequestWriterRepositoryInterface::class)->makePartial();
        $this->userRepo = m::mock(UserRepositoryInterface::class)->makePartial();
        $this->requestWriterController = new RequestAuthorController($this->requestWriterRepo, $this->userRepo);
    }

    public function tearDown() : void
    {
        unset($this->requestWriterRepo);
        unset($this->userRepo);
        unset($this->requestWriterController);
        unset($this->requestWriter);
        unset($this->users);
        parent::tearDown();
    }

    public function test_index_view()
    {
        $this->requestWriterRepo->shouldReceive('showRequestWriter')
            ->once()
            ->andReturn($this->users);
        $result = $this->requestWriterController->index();
        $this->assertEquals('website.backend.author_request.pending_request', $result->getName());
        $this->assertArrayHasKey('requestWriter', $result->getData());
    }

    public function test_update_find_id_fail()
    {
        $id = 1000000;
        $request = new Request();
        $this->requestWriterRepo->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn(null);
        $this->expectException(ErrorException::class);
        $this->requestWriterController->update($request, $id);
    }

    public function test_update_find_id_success()
    {
        $author = factory(User::class)->make([
            'role_id' => 2,
        ]);
        $requestWriter = factory(RequestWriter::class)->make([
            'user_id' => 1,
        ]);
        $id = 10;
        $request = new Request();
        $request['role_id'] = 1;
        $this->requestWriterRepo->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn($requestWriter);
        $this->userRepo->shouldReceive('update')
            ->with($requestWriter->user_id, [
                'role_id' =>  $request->role_id,
            ])
            ->once()
            ->andReturn($author);
        $this->requestWriterRepo->shouldReceive('delete')
            ->with($id)
            ->once()
            ->andReturn(true);
        $result = $this->requestWriterController->update($request, $id);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function test_destroy_method_find_id_fail()
    {
        $id = 2;
        $this->requestWriterRepo->shouldReceive('delete')
            ->with($id)
            ->once()
            ->andReturn(null);
        $this->requestWriterController->destroy($id);
    }

    public function test_destroy_method_find_id_true()
    {
        $id = 2;
        $this->requestWriterRepo->shouldReceive('delete')
            ->with($id)
            ->once()
            ->andReturn(true);
        $result = $this->requestWriterController->destroy($id);
        $this->assertInstanceOf(RedirectResponse::class, $result);
    }
}
