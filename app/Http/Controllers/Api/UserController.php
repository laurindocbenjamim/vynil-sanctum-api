<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        /*if(Storage::disk('s3')->exists('tutorial.pdf')){
                return Storage::download('tutorial.pdf');
        }*/
        $avatarPath = 'images/user-admin.png';
        try {
            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $name = $file->hashName();
                $avatarPath = $request->file('avatar')->storeAs(
                    'avatars',
                    $file->hashName(),
                    'public'
                );
            }
            $array = explode(' ', $request->input('name'));
            $name ='';
            if(count($array) >0){
                for ($i=0; $i < count($array); $i++) {
                    $name .= $array[$i];
                }
            }
            $user = User::create([
                'name' => empty($name) ? $request->input('name') : $name,
                'email' => $request->input('email'),
                'agree' => $request->input('agree'),
                'notify_me' => $request->input('notify'),
                'upload_limit' => $request->input('upload_limit'),
                'total_uploads' => 0,
                'password' => bcrypt($request->input('password')),
                'avatar' => $avatarPath,
            ]);

            $token = $user->createToken('vynil')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response, 200);

        } catch (\Throwable $th) {
            return response()->json(['save'=>false,'error'=> $th,'error_message'=> $th->getMessage()],201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $avatarPath = 'images/user-admin.png';
        try {
            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $name = $file->hashName();
                $avatarPath = $request->file('avatar')->storeAs(
                    'avatars',
                    $file->hashName(),
                    'public'
                );
            }
            $user = User::find($id)
            ->update([
                'name' =>$request->input('name'),
                'email' => $request->input('email'),
                'agree' => $request->input('agree'),
                'notify_me' => $request->input('notify'),
                'password' => bcrypt($request->input('password')),
                'avatar' => $avatarPath,
            ]);

            $token = $user->createToken('vynil')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response, 200);

        } catch (\Throwable $th) {
            return response()->json(['save'=>false,'error'=> $th,'error_message'=> $th->getMessage()],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
