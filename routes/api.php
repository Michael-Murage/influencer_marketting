<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ChatConversationController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\JobGigController;
use App\Http\Controllers\UserController;
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

Route::post('/jobs', [JobGigController::class, 'store']);
Route::get('/jobs', [JobGigController::class, 'index']);

Route::post('/profile_upload', [FileController::class, 'store'])->name('file.upload.store');

Route::get('/search_users', [UserController::class, 'search_users']);

Route::post('/new_campaign', [CampaignController::class, 'store']);
Route::get('/campaigns', [CampaignController::class, 'index']);
