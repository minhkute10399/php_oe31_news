<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestWriter;
use App\Models\Role;
use App\Models\User;
use App\Repositories\RequestWriter\RequestWriterRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class RequestAuthorController extends Controller
{
    protected $requestWriterRepo;
    protected $userRepo;

    public function __construct(RequestWriterRepositoryInterface $requestWriterRepo, UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');
        $this->requestWriterRepo = $requestWriterRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestWriter = $this->requestWriterRepo->showRequestWriter();

        return view('website.backend.author_request.pending_request', compact('requestWriter'));
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
        $requestWriter = $this->requestWriterRepo->find($id);

        $this->userRepo->update($requestWriter->user_id, [
            'role_id' => $request->role_id,
        ]);
        $this->requestWriterRepo->delete($id);
        toast(trans('message.successfully'),'success')->timerProgressBar();

        return redirect()->back();
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->requestWriterRepo->delete($id);

        Alert::success(trans('message.success'), trans('messsage.delete_successfully'));

        return redirect()->back();
    }
}
