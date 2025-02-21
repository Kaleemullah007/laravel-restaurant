<?php

use App\Models\Phrase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('save-data', function (Request $request) {

    Phrase::create(['name' => $request->userData]);

    return response()->json(['error' => false], 200)->header('Access-Control-Allow-Origin', '*') // Allow all origins
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE') // Allowed HTTP methods
        ->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
});
