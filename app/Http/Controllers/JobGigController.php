<?php

namespace App\Http\Controllers;

use App\Models\JobGig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class JobGigController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $jobs = JobGig::
                  paginate(20);
		return response()->json($jobs);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
  	return Inertia::render('Jobs');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
			'name' => 'required|string|max:255',
			'description' => 'required|string',
		]);

		$new_job = JobGig::create([
			'name' => $request->name,
			'description' => $request->description,
			'user_id' => $request->user_id,
		]);

		return response()->json($new_job);
  }

    /**
     * Display the specified resource.
     */
    public function show(JobGig $jobGig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobGig $jobGig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobGig $jobGig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobGig $jobGig)
    {
        //
    }
}
