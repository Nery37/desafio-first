<?php

declare(strict_types=1);

use App\Http\Controllers\UsersController;
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

Route::get('health', function () {
    return response()->json(['message' => 'FIRST']);
});

Route::post('user', [UsersController::class, 'createUser'])->name('register');;


Route::any('/{any}', function () {
    return response()->json(['message' => 'Invalid router'], 404);
})->where('any', '.*');
