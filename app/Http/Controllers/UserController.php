<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    protected $userRepo;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->middleware('auth');
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $users = $this->userRepo->listUser();

        return view('website.backend.users.list',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = $this->userRepo->find($id);

        return view('website.backend.users.edit', compact('users'));
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
        $users = $this->userRepo->find($id);
        Alert::success('Success', trans('message.ok'));
        $filename = config('image_user.image_user');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = md5(time()) . '.' . $extension;
            $file->move(public_path(config('image.image')), $filename);
            $users->image = $filename;
        }
        $this->userRepo->update($id, [
            'name' => $request->name,
            'email' => $request->email,
            'banned_until' => $request->banned_until,
            'image' => $filename,
        ]);

        return redirect()->route('users.index');
    }
}
