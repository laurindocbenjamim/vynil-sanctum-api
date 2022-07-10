<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
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
            $user = User::create([
                'name' =>$request->input('name'),
                'email' => $request->input('email'),
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
            return response()->json(['save'=>false,'error'=> $th,'error_message'=> $th->getMessage()],422);
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
        if($request->hasFile('file')){
            $path = $request->file('file')->storeAs(
                'avatars',
                $request->file->getClientOriginalName(),
                'public'
            );
            return response()->json(['success' => true, 'path'=> $path],200);
        }else{
            return response()->json(['success' => false],404);
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
