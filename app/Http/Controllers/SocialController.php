<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
  public function googleRedirect() {
    return Socialite::driver('google')->redirect();
  }

	public function googleLoginOrRegister() {
		$user = Socialite::driver('google')->user();
		
		$this->_registerOrLoginGoogleUser($user);

		return redirect()->route('dashboard');
	}

	protected function _registerOrLoginGoogleUser($incomingUser) {
		$user = User::where('google_id', $incomingUser->id)->first();

		if (!$user) {
			$emailParts = explode('@', $incomingUser->email);
			$firstLetters = $emailParts[0];
			
			$user = new User([
				'name' => $incomingUser->name,
				'username' => $firstLetters,
				'email' => $incomingUser->email,
				'email_verified_at' => now(),
				'password' => Hash::make(env('GOOGLE_USER_PASSWORD'), ['Password@321']),
				'google_id' => $incomingUser->id,
			]);

			$user->save();
		}

		Auth::login($user);
	}
}
