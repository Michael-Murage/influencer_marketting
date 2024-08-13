<?php

namespace App\Http\Controllers;

use App\Enums\ListTypeEnum;
use App\Models\ShortList;
use Illuminate\Http\Request;

class ShortListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $new_list = ShortList::create([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'list_type' => ListTypeEnum::USER_LIST,
        ]);

        return response()->json(['message' => 'success']);
    }

    public function myLists()
    {
        $user = auth()->user();
        $lists = ShortList::where('user_id', $user->id)
                            ->with('listItems')
                            ->get();

        return response()->json($lists);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortList $shortList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortList $shortList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortList $shortList)
    {
        //
    }
}
