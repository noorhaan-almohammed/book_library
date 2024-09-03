<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Services\UserService;
use App\Http\Requests\UserRequest\StoreRequest;
use App\Http\Requests\UserRequest\UpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected $userService ;
    public function __construct(){

       $this->userService = new UserService();

    }
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json(['users' => $users] , 200 );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->createuser($data);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $user = $this->userService->getUser($user);
            return response()->json([
                'user' => $user->name,
                'email'=> $user->email,
                'password'=> $user->password,
                'role'=> $user->role,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'user not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, user $user)
    {
        $data = $request->validated();
        $this->userService->updateUser($data , $user);
        return response()->json($user,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->deleteuser($user);
        return response()->json(['message' => 'user deleted'], 200);
    }
}
