<?php

namespace App\Http\Controllers;

use App\Core\DAL\UserRepository;
use App\Core\Helpers\Utilities;
use App\Core\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepository $UserRepository;
    public function __construct()
    {
        $this->UserRepository = new UserRepository(new User());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'skip' => 'Integer',
            'take' => 'required|Integer',
        ]);
        $response = $this->UserRepository->index($request->take, $request->skip);
        return Utilities::wrap($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|max:255',
            'address' => 'nullable',
            'image' => 'nullable|mimes:jpg,bmp,png',
        ]);
        $response = $this->UserRepository->store($data);
        return Utilities::wrap($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->UserRepository->show($id);
        return Utilities::wrap($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'password' => 'nullable|max:255',
            'address' => 'nullable',
            'image' => 'nullable|mimes:jpg,bmp,png',
        ]);
        $response = $this->UserRepository->edit($data, $id);
        return Utilities::wrap($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->UserRepository->delete($id);
        return Utilities::wrap($response);
    }
}
