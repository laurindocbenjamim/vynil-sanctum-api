<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaylistRequest;
use App\Models\MediaFile;
use App\Models\Playlist;
use App\Models\PlaylistHasTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlist = Playlist::join('media_files', 'playlists.mediafile_id', '=', 'media_files.id')
        ->join('albums', 'media_files.album_id', '=', 'albums.id')
        ->join('artists', 'albums.artist_id', '=', 'artists.id')
        ->select('playlists.*', 'artists.artist', 'artists.fullname',
        'artists.fullname', 'albums.title as album_title', 'albums.year_', 'albums.date_time', 'albums.style',
        'media_files.*')
        ->where('playlists.name','=','Default')
        ->get();
        return response()->json($playlist);
    }

    public function getAllPlaylists($userID){

        /*$playlist = Playlist::distinct('name')
        ->select('name')
        ->groupBy('name')
        ->where('user_id','=', $userID)
        ->get(); */
        $playlist = Playlist::where('user_id','=', $userID)
        ->get();
        return response()->json($playlist);
    }

    public function getPlaylist($userID, $name){

        $list = PlaylistHasTrack::join('media_files', 'playlist_has_tracks.mediafile_id', '=', 'media_files.id')
        ->join('playlists', 'playlist_has_tracks.playlist_id', '=', 'playlists.id')
        ->select('media_files.*', 'playlist_has_tracks.playlist_id','playlist_has_tracks.mediafile_id',
        'playlists.name', 'playlists.created_at as playlist_date')
        ->where('playlists.user_id', $userID)
        ->where(function($query) use ($name){
            $query->where('playlists.id', $name)
            ->orWhere('playlists.name', $name);
        })
        ->get();

        if($list){
            return response()->json($list);
        }
        return response()->json([
            'list'=> $list,
            'message' => 'The password is wrong! '
        ],202);
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
    public function store(PlaylistRequest $request)
    {
        try {
            if(is_array($request->trackList)){
                $tracks = $request->trackList;
                $count =0;
                DB::beginTransaction();

                $pl = Playlist::create([
                    'name' => $request->name,
                    'code_list' => bcrypt($request->name.''.$request->user()->id),
                    'user_id' => $request->user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                for ($i=0; $i < count($tracks); $i++) {
                    PlaylistHasTrack::create([
                        'playlist_id' => $pl->id,
                        'mediafile_id' => $tracks[$i],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    $count ++;
                }

                DB::commit();

                if($count == count($tracks)){
                    return response()->json(['message'=>'Playlist created successfull!'], 200);
                }

            }
            return response()->json(['trackList'=>is_array($request->trackList)],201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['errors'=>$th,'error'=>$th->getMessage()],201);
        }
    }

    public function addTrack(Request $request)
    {
        $request->validate([
            'tracks.*' => 'required|string|distinct|min:1',
            'playlistID' => 'required|numeric',
        ],[
            'tracks.required' => 'A track list identity required',
            'playlistID.required' => 'The playlist identity required',
            'playlistID' => 'The playlist identity must be numeric type',
        ]);
        try {
            if(is_array($request->tracks)){
                $tracks = $request->tracks;
                $count =0;

                for ($i=0; $i < count($tracks); $i++) {
                    PlaylistHasTrack::create([
                        'playlist_id' => $request->playlistID,
                        'mediafile_id' => $tracks[$i],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $count ++;
                }

                if($count == count($tracks)){
                    return response()->json(['message'=>'Playlist created successfull!'], 200);
                }
            }
            return response()->json(['trackList'=>is_array($request->tracks)],201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['errors'=>$th,'error'=>$th->getMessage()],201);
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
        return response()->json("Ola");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlaylistRequest $request, $id)
    {
        try {
            if(is_array($request->trackList)){
                $tracks = $request->trackList;
                $count =0;
                for ($i=0; $i < count($tracks); $i++) {
                    Playlist::find($tracks[$i])
                    ->update([
                        'name' => $request->name,
                        'code_list' => bcrypt($request->name.''.Auth::user()->id),
                        'user_id' => Auth::user()->id,
                        'mediafile_id' => $tracks[$i],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $count ++;
                }
                if($count == count($tracks)){
                    return response()->json(['message'=>'Playlist created successfull!'], 200);
                }
            }
                return response()->json(['trackList'=>is_array($request->trackList)]);

        } catch (\Throwable $th) {
            return response()->json(['errors'=>$th,'error'=>$th->getMessage()],422);
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
        try {


        } catch (\Throwable $th) {
            return response()->json(['errors'=>$th,'error'=>$th->getMessage()],422);
        }
    }
}
