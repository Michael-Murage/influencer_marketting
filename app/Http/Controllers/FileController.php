<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class FileController extends Controller
{
  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    Validator::make($request->all(), [
			'file' => ['required'],
		])->validate();

		$request->file->move(public_path('storage'), $request->name);

		File::create([
			'name' => $request->name,
			'user_id' => $request->user_id
		]);
  }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }
}
