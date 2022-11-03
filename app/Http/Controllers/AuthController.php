<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
        $this->middleware('permission:create-normal-user')->only('register');
        $this->middleware('permission:view-all')->only('index');
        $this->middleware('permission:edit-all')->only('show');
        $this->middleware('permission:view-user')->only('show');
        $this->middleware('permission:edit-all')->only('show');

        
    }
    public function index()
    {
        return response()->json([
            'message' => trans("response.test"),
            'data' => User::class,
        ] , Response::HTTP_ACCEPTED);
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('name', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(RegisterUserRequest $request){

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'city' => $request->city,
            'address' => $request->address,
            'blood_type_id' => $request->blood_type_id,
            'national_number' => $request->national_number,
            'sex' => $request->sex,
            'age' => $request->age,
            'weight' => $request->weight,
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function update(Request $request,  $user)
    {
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:6',
                'phone_number' => 'required|string|max:255|unique:users',
                'city' => 'required|in:latakia,damascus,homs',
                'address' => 'required',
                'national_number' => 'required|string',
                'age' => 'required|integer|min:18',
                'weight' => 'required|integer',
        ]);
        User::where('id','=',$user)->update([
            "name" => $request->name,
            "password" => $request->password,
            "phone_number" => $request->phone_number,
            "city" => $request->city,
            "address" => $request->address,
            "national_number" => $request->national_number,
            "weight" => $request->weight,
            "age" => $request->age,
            
            
        ]);
        return response()->json([
            "message" => "Data Updated Successfuly",
            
        ] , Response::HTTP_ACCEPTED);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
