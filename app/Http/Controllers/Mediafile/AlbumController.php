<?php

namespace App\Http\Controllers\MediaFile;

use App\Http\Controllers\Api\StoreFileController;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Album::all());
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
        $store = new StoreFileController();
        try {
            $resp = $store->upload($request,'slug');
            /*DB::beginTransaction();

            if($resp['uploaded']){
                $ar = Artist::create([
                    'artist' => $request->artist,
                    'fullname' => $request->fullname,
                    'user_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $al = Album::create([
                    'title' => $request->title_album,
                    'artist_id' => $ar->id,
                    'slug'=> $resp['path'],
                    'user_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                DB::commit();

                return response()->json(['saved'=> true, 'albumID' => $al->id], 200);
            }else{
                return response()->json(['saved'=> false, 'message'=>'Failed to upload file'], 202);
            }*/
            return response()->json([
                'path'=>$resp,
                'album' => Auth::check(),
                'user' => Auth::user()
            ],201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['saved'=>false,'errors'=> $th,'message'=> $th->getMessage()],422);
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
        //
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
