<?php

use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// if (env('APP_ENV') === 'production') {
  // URL::forceScheme('https');
// }

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/brand_dashboard', function () {
  return Inertia::render('BrandDashboard', ['auth' => ['user' => Auth::guard('brands')->user()]]);
})->name('brand_dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  
  Route::get('/messages', [ChatMessageController::class, 'create']);
});

Route::get('/brand/extra_info', function () {
  return Inertia::render('Brand/ExtraInfo');
})->middleware(['auth'])->name('brand.extra_info');

Route::get('/influencer/extra_info', function () {
  return Inertia::render('Influencer/ExtraInfo');
})->middleware(['auth'])->name('influencer.extra_info');

// Route::get('/verifyEmail', function () {
//   return Inertia::render('Auth/VerifyEmail');
// });

Route::get('/email/verify', function () {
  return Inertia::render('Auth/VerifyEmail');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
	$request->fulfill();

	return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
	$request->user()->sendEmailVerificationNotification();

	return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/auth/choose_signup', function () {
  return Inertia::render('Auth/ChooseSignup');
})->name('choose_signup');


Route::get('auth/google', [SocialController::class, 'googleRedirect']);
Route::get('auth/google/callback', [SocialController::class, 'googleLoginOrRegister']);

require __DIR__.'/auth.php';
