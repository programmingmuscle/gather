<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;

class MessagesController extends Controller
{
	public function store(MessageRequest $request)
	{
		$message = new Message;

		$message->user_id            = $request->user_id;
		$message->post_id            = $request->post_id;
		$message->user_name          = $request->user_name;
		$message->user_profile_image = $request->user_profile_image;
		$message->content            = $request->content;

		$message->save();

		return back();
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'content' => 'required|string|max:191',
		], [
			'content.required' => '空のメッセージは送信できません。',
			'content.string'   => 'メッセージは文字列として下さい。',
			'content.max'      => 'メッセージは191文字以内として下さい。',
		]);

		$message = Message::find($id);

		$message->user_id            = $request->user_id;
		$message->post_id            = $request->post_id;
		$message->user_name          = $request->user_name;
		$message->user_profile_image = $request->user_profile_image;
		$message->content            = $request->content;

		$message->save();

		return back();
	}

	public function destroy($id)
	{
		$message = Message::find($id);

		$message->delete();

		return back();
	}
}
