<?php

use App\Models\Live\CCAgent;
use Illuminate\Http\Request;
use App\Models\Configurations;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Live\Recordings;
use App\Http\Controllers\CdrController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/cdr/cdr', [CdrController::class, 'saveCdr']);
//Route::post('/cdr/cdr', 'CdrController@store');

//'CdrController@store';
Route::post('/recordings', [Recordings::class, 'store']);

Route::get('/agents', function (Request $request) {
    return CCAgent::get();
});

Route::get('/session', function () {
    return response()->json([
        'session' => session()->all(),
    ]);
});

Route::get('/agent', function (Request $request) {

    $man_no= $request->input('man_no');
    $user = CCAgent::where('man_no', '=', $man_no)->first();
    return $user;
});


Route::get('/pbxkey', function (Request $request) {
    $username = Configurations::where('config_key_id', '=', 'pbx_username')->first();
    $password = Configurations::where('config_key_id', '=', 'pbx_password')->first();
    //dd($password->config_value);
    try {
        $decrypted = Crypt::decrypt($password->config_value);
        // dd($decrypted);
        return ["username" => $username->config_value, "password" => $decrypted];
    } catch (\Exception $e) {
        return ["error" => $e];
    }

    return [];
});

//token:"1|AqvdIFi3ouMuuUGgUvxtxB3JYUrBQxVTvEeAlXBs"

Route::middleware('auth:sanctum')->get('/pbxkey', function (Request $request) {
    $username = Configurations::where('config_key_id', '=', 'pbx_username')->first();
    $password = Configurations::where('config_key_id', '=', 'pbx_password')->first();
    //dd($password->config_value);
    try {
        $decrypted = Crypt::decrypt($password->config_value);
        // dd($decrypted);
        return ["username" => $username->config_value, "password" => $decrypted];
    } catch (\Exception $e) {
        return ["error" => $e];
    }

    return [];
});
