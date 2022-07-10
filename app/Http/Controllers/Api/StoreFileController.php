<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreFileController extends Controller
{
    public static function upload($request,$inputfield,$folder = "avatars"){
        if($request->hasFile($inputfield)){
            $filePath = '';
            $file = $request->file($inputfield);
            $originalName = $file->getClientOriginalName();
            $name = $file->hashName();
            $extension = $file->extension();

            if($folder == "avatars" || $folder =='' || $folder ==null){
                if($extension === 'png'||$extension === 'jpg'
                ||$extension === 'jpeg'){
                    $folder = "avatars";
                }else if($extension === 'mp3'||$extension === 'wave'){
                    $folder = "tracks";
                }
            }

            $filePath = $request->file($inputfield)->storeAs(
                $folder,
                $file->hashName(),
                'public'
            );

            return ['uploaded' => true, 'path'=> $filePath,'name'=>$name,
            'originalName'=>$originalName];
        }
        return ['uploaded' => false,'message'=> 'Input file request null!'];
    }

    public static function download($filePath, $fileName){
        try {
            return Storage::download($filePath, $fileName);
        } catch (\Throwable $th) {
               return response()->json(['errors'=> $th, 'error'=>$th->getMessage()]);
        }
    }
}
