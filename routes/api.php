<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ViewController;
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

Route::post('/auth/forgotPassword', [AuthController::class, 'forgotPassword']);

Route::middleware('auth:sanctum')->get('/auth/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/userInfo', function (Request $request) {
    $user = Auth::user();
    return response()->json([
        'user' => $user,
    ]);
});
// end test

Route::prefix('/section')->group(function () {
    Route::get('get', [SectionController::class, 'index']);
    Route::get('/getAll', [SectionController::class, 'showAll']);
    Route::post('/create', [SectionController::class, 'create']);
    Route::patch('/update/{id}', [SectionController::class, 'update']);
    Route::delete('/delete/{id}', [SectionController::class, 'destroy']);
});

Route::prefix('/theme')->group(function () {
    Route::get('/getAll', [ThemeController::class, 'showAll']);
    Route::post('/get', [ThemeController::class, 'get']);
    Route::post('/getContent', [ThemeController::class, 'getContent']);
    Route::post('/create', [ThemeController::class, 'create']);
    Route::post('/createDescription', [ThemeController::class, 'createDescription']);
    Route::post('/imageUpload', [ThemeController::class, 'uploadImage']);
    Route::post('/imageRemove', [ThemeController::class, 'removeImage']);
    Route::patch('/update/{id}', [ThemeController::class, 'update']);

    Route::post('/search', [ThemeController::class, 'search']);

    Route::delete('/delete/{id}', [ThemeController::class, 'delete']);
});

Route::prefix('/view')->group(function () {
    Route::get('/getViews', [ViewController::class, 'getViews']);
    Route::post('/create', [ViewController::class, 'create']);
    Route::post('/delete', [ViewController::class, 'delete']);
});
