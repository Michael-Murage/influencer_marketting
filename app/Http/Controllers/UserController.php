<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;

class UserController extends Controller
{
  public function index() {
    $users = User::select('name', 'username', 'id')->get();

    return response()->json($users);
  }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {

    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
      
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
      
    }
}
