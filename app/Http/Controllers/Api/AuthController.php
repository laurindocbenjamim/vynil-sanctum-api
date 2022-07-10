<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function verifyUserEmail($email)
    {
        try {
            $rs = User::where('email', $email)->exists();
            return response()->json($rs);
        } catch (\Throwable $th) {
            return response()->json(['errors'=>$th,'error'=>$th->getMessage()],422);
        }
    }

    public function verifyUserPassword(LoginPasswordRequest $req)
    {
        try {
            /*if(Auth::attempt(['email' => $req->input('userEmail'),
                'password' => $req->input('password')]))
            {
                $user = User::where('email', $req->input('userEmail'))->first();
                $token = $user->createToken('mediaWalletToken')->plainTextToken;

                Session::put('token', $token);
                $response = [
                    'loggin_check'=> Auth::check(),
                    'user' => Auth::user(),
                    'token' => $token,
                    'session' => Session::get('token'),
                    'user_id' => Auth::user()->id,
                ];

                return response()->json($response, 200);
            }
            return response()->json(['loggin'=>Auth::check()],201);*/

            //check email
            $user = User::where('email', $req->input('userEmail'))->first();
            //check password
            if(!$user || !Hash::check($req->input('password'), $user->password)){
                return response()->json([
                    'message' => 'The password is wrong! '.$req->device_name
                ],202);
            }

            $token = $user->createToken('mediaWalletToken')->plainTextToken;

            Session::put('token', $token);

            $response = [
                'user' => $user,
                'token' => $token,
                'loggin_check'=> Auth::check(),
                'token' => $token,
                'session' => Session::get('token'),
            ];

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json(['errors'=>$th,'error'=>$th->getMessage()],201);
        }
    }

    public function logout(Request $request)
    {
        try {
            return response()->json(['loggin_check'=>Auth::check(),'user'=> Auth::user()]);
            //$rs =auth()->user()->tokens()->delete();
            $rs = $request->user()->tokens()->delete();
            if(Auth::guard('user')->logout()){
                return response()->json(
                    ['loggin_check'=> Auth::check(),
                    'logout'=> !Auth::check(),
                    'user'=> Auth::user(),
                    'deleteToken' => $rs
                    ],200);
            }
            return response()->json([
                'logout'=> !Auth::check(),
                'loggin'=> Auth::check(),
                'user'=> Auth::user(),
                'delete_token' => $rs
            ],201);
        } catch (\Throwable $th) {
            return response()->json(['errors'=>$th,'error'=>$th->getMessage(),'logout'=>false],422);
        }
    }

    public function checkSessionToken($token){
        if(Session::get('token') == $token)
            return response()->json(['hasToken'=> true]);
        return response()->json(['hasToken'=> false,'token'=> Session::get('token')]);
    }

}
