<?php

namespace App\Http\Controllers;

use App\Models\JobGig;
use App\Models\JobGigApplication;
use Illuminate\Http\Request;

class JobGigApplicationController extends Controller
{
  public function getApplications(Request $request) {
		$job = JobGig::find($request->job_id);
		$auth_user = auth()->user();

		if ($job && $auth_user) {
			$applications = JobGigApplication::with(['applicationWithUserDetails'])
																				->where('job_gig_id', $job->id)
																				->paginate(20);

			return response()->json($applications);
		}
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $user_id = auth()->user()->id;
    $job = JobGig::find($request->jobId);

    $job_applied = JobGigApplication::where('user_id', $user_id)->where('job_gig_id', $job->id)->count();
    
    if (!$job_applied) {
			$new_application = JobGigApplication::create([
				'user_id' => $user_id,
				'job_gig_id' => $job->id,
			]);

      return response()->json($new_application);
    } else {
      abort(422, 'Already applied');
    }
  }

  public function job_applied(Request $request)
  {
    $job = JobGig::find($request->job_id);
		$user_id = auth()->user()->id;
		$application = JobGigApplication::where('job_gig_id', $job->id)->where('user_id', $user_id);
		if ($application) {
			$application = $application->count();
		}

		return response()->json(['status' => !!$application]);
  }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobGigApplication $JobGigApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobGigApplication $JobGigApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobGigApplication $JobGigApplication)
    {
        //
    }
}
