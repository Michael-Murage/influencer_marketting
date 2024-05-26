<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatConversationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index($user_id)
  {
    $conversations = ChatConversation::where('user_1_id', $user_id)
																			->orWhere('user_2_id', $user_id)
																			->with('latestMessage')
																			->paginate(20);

		return response()->json($conversations);
  }

  /**
   * 
   */
  public function conversationMessages($conversation_id)
  {
    $conversation = ChatConversation::find($conversation_id);
		$messages = $conversation->chatMessages()->paginate(20);
		return response()->json($messages);
  }

	public function conversationUsers($conversation_id)
	{
		$conversation = ChatConversation::find($conversation_id);
		$user_1 = User::find($conversation->user_1_id);
		$user_2 = User::find($conversation->user_2_id);
		return response()->json([$user_1, $user_2]);
	}

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
			'user' => 'required',
			'message' => 'required',
			'sender' => 'required',
		]);

		$user = User::find($request->user);
		$message = $request->message;
		$sender = User::find($request->sender);

		$new_convo_collection = ChatConversation::where('user_1_id', $request->user)
																						->where('user_2_id', $request->sender)
																						->orWhere('user_1_id', $request->sender)
																						->where('user_2_id', $request->user)
																						->get();
		$new_convo = null;

		if (!count($new_convo_collection)) {
			$new_convo = ChatConversation::create([
				'user_1_id' => $sender->id,
				'user_2_id' => $user->id,
				'user_1_name' => $sender->name,
				'user_2_name' => $user->name,
			]);
		} else {
			$new_convo = $new_convo_collection[0];
		}

		$new_message = ChatMessage::create([
			'content' => $message,
			'chat_conversation_id' => $new_convo->id,
			'sender_id' => $request->sender,
			'user_id' => $request->user,
		]);
		
		return response()->json(['message' => 'Message created successfully']);
  }

    /**
     * Display the specified resource.
     */
    public function show(ChatConversation $chatConversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChatConversation $chatConversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChatConversation $chatConversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatConversation $chatConversation)
    {
        //
    }
}
