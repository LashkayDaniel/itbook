<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// test
Route::get('sections', [\App\Http\Controllers\SectionController::class, 'index']);

// Добавьте это ↓
Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('restrictothers');

// Страница создания токена
Route::get('dashboard', function () {
    if (Auth::check() && Auth::user()->role === 1) {
        return auth()
            ->user()
            ->createToken('auth_token', ['admin'])
            ->plainTextToken;
    }
    return response()->json('okk');//redirect("/");
})->middleware('auth');

Route::get('clear/token', function () {
    if (Auth::check() && Auth::user()->role === 1) {
        Auth::user()->tokens()->delete();
    }
    return 'Token Cleared';
})->middleware('auth');

Route::group(['middleware' => 'auth:sanctum'], function () {
    ////-----
    /// -----

    // добавить сообщение
    Route::post('admin', [MainController::class, 'admin']);
    Route::post('section', [MainController::class, 'createSection']);
    // обновить сообщение
    Route::put('section/{id}', [MainController::class, 'updateSection']);
    // добавить сообщение
    Route::post('theme', [MainController::class, 'createTheme']);
    // обновить сообщение
    Route::put('theme/{id}', [MainController::class, 'updateTheme']);
    // удалить сообщение
    Route::delete('section/{id}', [MainController::class, 'deleteSection']);
    // удалить сообщение
    Route::delete('theme/{id}', [MainController::class, 'deleteTheme']);
    // добавить нового пользователя с ролью Writer
    Route::post('users/user', [MainController::class, 'createUser']);
    // удалить пользователя
    Route::delete('users/{id}', [MainController::class, 'deleteUser']);
});
//
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/registerAdmin', [AuthController::class, 'registerAdmin']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/adminLogin', [AuthController::class, 'adminLogin']);
Route::post('/auth/checkToken', [AuthController::class, 'checkToken']);

Route::middleware('auth:sanctum')->get('/auth/logout', [AuthController::class, 'logout']);
// end test
