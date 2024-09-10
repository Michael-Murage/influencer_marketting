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
    $auth_user = auth()->user();
    $jobs = JobGig::with('userInformation')
									->where('job_gigs.user_id', '!=', $auth_user->id)
                  ->paginate(20);
		return response()->json($jobs);
  }

  public function myJobs()
  {
    $auth_user = auth()->user();
    $jobs = JobGig::with('userInformation')
									->where('user_id', $auth_user->id)
                  ->paginate(20);
		return response()->json($jobs);
  }

  public function myJobDetails(Request $request) {
    $auth_user = auth()->user();
    $job = JobGig::find($request->job_id);

    if ($job->user_id == $auth_user->id) {
      return response()->json($job);
    }
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
    dd($request->user_id);
    $request->validate([
			'name' => 'required|string|max:255',
			'description' => 'required|string',
      'role' => 'required|string',
		]);
dump($request->name);
		$new_job = JobGig::create([
			'name' => $request->name,
			'description' => $request->description,
			'user_id' => $request->user_id,
      'role' => $request->role,
      'qualifications' => $request->qualifications,
		]);

		return response()->json($new_job);
  }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
      $job_gig_id = $request->job_id;
			$job_gig = JobGig::with('userInformation')->find($job_gig_id);
			return response()->json($job_gig);
    }

    public function singleJobPage() {
			return Inertia::render('Jobs/Id');
		}

    public function myJobsPage() {
      return Inertia::render('MyJobs/index');
    }

    public function viewMyJobDetails() {
      return Inertia::render('MyJobs/Id');
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
