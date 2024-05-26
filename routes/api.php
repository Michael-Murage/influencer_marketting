<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatConversationController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('verify_info', [RegisteredUserController::class, 'verifyInfo'])->name('verify_info');
Route::get('/verifyEmail', [RegisteredUserController::class, 'verifyEmailPage']);

Route::post('/skip_extra_info/{user_id}', [RegisteredUserController::class, 'skipExtraInfo']);
Route::post('/submit_extra_info', [RegisteredUserController::class, 'submitExtraInfo']);
Route::get('/test', function() {
    return response()->json(['message' => 'test']);
});

Route::get('/users', [UserController::class, 'index']);

Route::get('/conversations/{user_id}', [ChatConversationController::class, 'index']);
Route::post('/conversations', [ChatConversationController::class, 'store']);
Route::get('/conversation_messages/{conversation_id}', [ChatConversationController::class, 'conversationMessages']);
Route::get('/conversation_users/{conversation_id}', [ChatConversationController::class, 'conversationUsers']);

Route::post('/chat_messages', [ChatMessageController::class, 'store']);
