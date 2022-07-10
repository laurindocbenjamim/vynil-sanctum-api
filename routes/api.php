<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\MediaFile\AlbumController;
use App\Http\Controllers\Mediafile\MediaFileController;
use App\Http\Controllers\SubscriberController;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('user/auth/verify/{email}', [AuthController::class, 'verifyUserEmail'])->name('users.auth.verify');
Route::post('user/auth/signin', [AuthController::class, 'verifyUserPassword'])->name('users.auth.signin');

Route::post('users/signup', [UserController::class, 'store']);
Route::get('check-session/{token}', [AuthController::class, 'checkSessionToken']);

Route::get('albums/all', [AlbumController::class, 'index']);
Route::get('mediafile/all', [MediaFileController::class, 'index']);


Route::group(['middleware' => ['auth:sanctum']], function(){

    //Route::get('user/auth/logout/{logout}', [AuthController::class, 'logout']);
    //Route::resource('user', UserController::class);
    Route::resource('logout', LogoutController::class);
    Route::resource('player', PlaylistController::class);
    Route::get('/tracklists/{userID}', [PlaylistController::class, 'getAllPlaylists']);
    Route::get('/select/playlist/{userid}/{name}', [PlaylistController::class, 'getPlaylist']);

    Route::resource('album', AlbumController::class);
    Route::resource('mediafile', MediaFileController::class);
    Route::post('mediafile/download-track', [MediaFileController::class, 'downloadTracks']);
    Route::post('/search', [MediaFileController::class,'selectTrack']);
    Route::resource('playlist', PlaylistController::class);
    Route::post('playlist/add-track', [PlaylistController::class, 'addTrack']);
    Route::resource('subscribe', SubscriberController::class);
});
Route::get('/media-download', [MediaFileController::class, 'down']);
