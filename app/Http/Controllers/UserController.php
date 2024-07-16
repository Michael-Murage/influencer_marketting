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

  public function search_users(Request $request) {
    $search_text = $request->search;
    
    $search_result = User::where('name', 'like', "%$search_text%")
                          ->orWhere('username', 'like', "%$search_text%")
                          ->orderBy('name', 'DESC')
                          ->get();

    return response()->json($search_result);
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
