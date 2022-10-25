<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function login(Request $request){

           $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return $this->sendError('unauthorized' ,'authentication failed', 505);
        }

        $user = User::where('email', $request->email)->first();

        if(!Hash::check($request->password, $user->password, [])){
            throw new \Exception('invalid credentials');
        }

        $token = $user->createToken('windiToken')->accessToken;

        return $this->sendResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 'Authenticated');
    }


    public function register(Request $request){
      
        $cekData = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6']
        ]);

        if ($cekData->fails()) {
            return $this->sendError('register tidak berhasil', $cekData->errors(), 422);
        }

        $newUser = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $newUser->createToken('windiToken')->accessToken;

        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $newUser
        ];

        return $this->sendResponse($data, 'successful register');

    }

    public function details(){
   
        $user = Auth::user();
        return $this->sendResponse($user, 'profile data user');
     
      
    }


    public function logout(Request $request){
        $request->user()->token()->revoke();
        return $this->sendResponse('successful logout',200);
    }
}
