<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   */
  public function create(): Response
  {
  	return Inertia::render('Auth/Register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request)
  {
    $request->validate([
			'country_code' => ['required', 'string'],
			'phone_number' => ['required', 'min:9', 'max:10'],
			'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

		if ($request->terms_and_conditions) {
			$user = User::create([
				'name' => $request->name,
				'username' => $request->username,
				'gender' => $request->gender,
				'phone_number' => $request->country_code . $request->phone_number,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'user_type' => $request->type == 'Brand' ? UserRole::BRAND : UserRole::INFLUENCER,
				'company_name' => $request->company_name,
			]);
	
			event(new Registered($user));
	
			Auth::login($user);
		} else {
			return response()->json(['terms_and_conditions' => ['Please read and accept the terms and conditions']], 422);
		}

  }

	public function verifyInfo(Request $request) {
		$validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'regex:/^[a-zA-Z\w]+$/'],
			'gender' => ['required', 'string', 'max:255'],
			'country' => ['required', 'string', 'max:255'],
			'company_name' => ['required', 'string', 'max:255'],
		]);

		if ($validator && $validator->fails()) {
			return response()->json($validator->errors(), 422);
		} else {
			return response()->json([], 200);
		}
	}

	public function verifyEmailPage() {
		return Inertia::render('/register', ['page' => 4]);
	}

	public function skipExtraInfo(Request $request) {
		$user_id = $request->user_id;

		$user = User::find($user_id);

		$user->info_gathering_prompted = true;
		$user->save();
		return response()->json(["message" => "success"]);
	}

	public function submitExtraInfo(Request $request) {
		$user_id = $request->id;

		$user = User::find($user_id);

		if ($user) {
			$file = \App\Models\File::where('user_id', $user->id)->where('name', 'LIKE', "%profilePic%")->first();
			if ($file) {
				$file = $file->id;
			}
			
			$user->update([
				'active_socials' => implode(',', $request->active_socials),
				'interest' => implode(',', $request->interest),
				'profession' => implode(',', $request->profession),
				'profile_pic' => $file || null,
			]);

			$user->info_gathering_prompted = true;
			$user->save();
			return response()->json(["message" => "success"]);
		}

	}
}
