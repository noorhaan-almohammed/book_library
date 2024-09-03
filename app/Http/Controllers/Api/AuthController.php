<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\registerRequest;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    protected $authService;
    /**
     * inject auth service
     * @param \App\Http\Services\AuthService $authService
     */
    public function __construct(AuthService $authService){
        // inject book service
         $this->authService = $authService;
         $this->middleware('auth')->only('logout','profile');
    }
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->authService->register($validatedData);
        $token = auth()->login($user);
        return $this->respondWithToken($token,$user);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $token = $this->authService->attemptLogin($credentials);
        if (!$token) {
            return response()->json(['errors' => 'Invalid email and password'], 401);
        }
        return $this->respondToken($token);
    }
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user]);
    }
    public function logout()
    {
        $this->authService->logout();
        return response()->json(['message' => 'Successfully logged out']);

    }
    public function respondToken($token)
    {   $expiresIn = config('jwt.ttl') * 60;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>   $expiresIn
        ]);
    }
    public function respondWithToken($token , $user){
        return response()->json([ 'access_token' => $token,
                                  'token_type' => 'bearer',
                                  'user'=> $user]);
    }

}
