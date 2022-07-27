<?php

namespace App\Http\Controllers\Mediafile;

use App\Http\Controllers\Api\StoreFileController;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\MediaFile;
use App\Models\PlaylistHasTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaFileController extends Controller
{
    public function index(){
        $rs = MediaFile::limit('15')->get();
        return response()->json($rs);
    }

    public function selectTrack(Request $request){
        try {
            $list = MediaFile::where('artist', 'like','%'.$request->param.'%')
            ->orWhere('title', 'like','%'.$request->param.'%')
            ->orWhere('feat', 'like','%'.$request->param.'%')
            ->orWhere('id', $request->param)
            ->get();
            return response()->json($list,200);
        } catch (\Throwable $th) {
            return response()->json(['errors'=>$th,'error'=>$th->getMessage()],201);
        }
    }

    public function store(Request $request){
            $store = new StoreFileController();
            $store2 = new StoreFileController();
        try {

            $image_path = $store->upload($request,'slug', 'images');
            $track_path = $store2->upload($request,'track', 'tracks');

            if($track_path['uploaded']==true){
                $feat = '';
                if($request->input('feat') !='' && $request->input('feat') !='null'
                && $request->input('feat') !=null){
                    $feat = 'feat. '.$request->input('feat');
                }
                $mf = MediaFile::create([
                    'artist' => $request->input('artist'),
                    'title' => $request->input('title_mediafile'),
                    'feat' => $feat,
                    'original_name' => $track_path['originalName'],
                    'genre' => $request->input('genre'),
                    'track_path' => $track_path['path'],
                    'track_image' => $image_path['path'],
                    'launched_date' => $request->input('launched_date'),
                    'for_download' => $request->input('for_download'),
                    'user_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                return response()->json(['saved'=> true, 'message'=>'Track uploaded successfull!',
                'mediaID' => $mf->id], 200);
            }
            return response()->json(['saved'=> false, 'error' => 'Upload track failed! There is something
            wrong in server.'], 201);

        } catch (\Throwable $th) {
            return response()->json(['saved'=>false,'errors'=> $th,'message'=> $th->getMessage()],201);
        }
    }

    public function update(Request $request, $id){

        try {
                $feat = '';
                if($request->input('feat') !='' && $request->input('feat') !='null'
                && $request->input('feat') !=null){
                    $feat = 'feat. '.$request->input('feat');
                }
                $mf = MediaFile::find($id)
                ->update([
                    'artist' => $request->input('artist'),
                    'title' => $request->input('title_mediafile'),
                    'feat' => $feat,
                    'genre' => $request->input('genre'),
                    'for_download' => $request->input('for_download'),
                    'launched_date' => $request->input('launched_date'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                return response()->json(['saved'=> true, 'message'=>'Track updated successfull!'], 200);

        } catch (\Throwable $th) {
            return response()->json(['saved'=>false,'errors'=> $th,'message'=> $th->getMessage()],201);
        }
    }

    public function downloadTracks(Request $request){
        $request->validate([
            'artist' => 'required|string',
            'feat' => 'nullable|string',
            'title' => 'required|string',
            'track_path' => 'required|string',
            'tracks.*' => 'required|string|distinct|min:1',
        ],[
            'artist.required' => 'A artist list identity required',
            'artist.string' => 'A artist list identity required',
            'feat.string' => 'A feat list identity required',
            'title.required' => 'A title list identity required',
            'title.string' => 'A title list identity required',
            'tracks.required' => 'A track list identity required',
        ]);

        try {
            if(is_array($request->tracks)){
                $tracks = $request->tracks;
                $count =0;

                for ($i=0; $i < count($tracks); $i++) {
                    StoreFileController::download(
                        $request->track_path,
                        $request->artist.' '.$request->feat.'-'.$request->title,
                    );

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

    public function down(){
        $path = 'http://127.0.0.1:8000/storage/tracks/2xkxwdrlua7CXtD3pe3W9t9tGAVoiZ5pmLDn4II6.mp3';
        $name = 'Valete-Viaja (Visualizer)';
        /*StoreFileController::download(
            $path,
            $name
        );*/
        return Storage::download($path, $name);
    }

    public function destroy($id){
        try {
            DB::beginTransaction();

            $mf = MediaFile::find($id);
            $pl = PlaylistHasTrack::where('mediafile_id', $mf->id)
                ->delete();

            $rs3 = MediaFile::destroy($mf->id);

            if($mf){
                $rs1 = Storage::delete($mf->track_path);
                $rs2 = Storage::delete($mf->track_image);

                DB::commit();
                return response()->json(['deleted'=>true],200);
            }
            DB::rollBack();
            return response()->json(['deleted'=>false],201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['errors'=>$th,'error'=>$th->getMessage()],201);
        }
    }
}
