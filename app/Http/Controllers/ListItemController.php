<?php

namespace App\Http\Controllers;

use App\Models\ListItem;
use Illuminate\Http\Request;

class ListItemController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function listItemsByListId(Request $request)
  {
    $list_ids = $request->lists;
		$list_items = ListItem::whereIn('short_list_id', $list_ids)
													->with('user:id,name,username')
													->get()
													->groupBy('short_list_id');

		return response()->json($list_items);
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
    if ($request->list_id && $request->user_id) {
      $new_list_item = ListItem::create([
				'short_list_id' => $request->list_id,
				'user_id' => $request->user_id,
			]);

			return response()->json(['success' => true]);
    }

		return response()->json(['success' => false]);
  }

    /**
     * Display the specified resource.
     */
    public function show(ListItem $listItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListItem $listItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListItem $listItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListItem $listItem)
    {
        //
    }
}
