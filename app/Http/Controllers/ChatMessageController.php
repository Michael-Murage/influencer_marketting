<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatMessageController extends Controller
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
    return Inertia::render('Messages');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
			'message' => 'required',
		]);

		$newMessage = ChatMessage::create([
			'content' => $request->message,
			'chat_conversation_id' => $request->chat_conversation_id,
			'sender_id' => $request->sender_id,
			'user_id' => $request->user_id,
		]);

		event(new \App\Events\ChatMessageEvent($newMessage, $request->chat_conversation_id));

		return response()->json(['message' => 'Message created successfully']);
  }

    /**
     * Display the specified resource.
     */
    public function show(ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatMessage $chatMessage)
    {
        //
    }
}
