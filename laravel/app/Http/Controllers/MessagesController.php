<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use App\Message;

use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function store(Request $request, $id) {
        $this->validate($request, [
            'content' => 'required|string|max:191',
        ], 
        [
            'content.required' => 'タイトルを入力して下さい。',
            'content.string' => 'タイトルは文字列として下さい。',
            'content.max' => 'タイトルは191文字以内として下さい。',
        ]);

        $message = new Message;
        $post = Post::find($id);

        $message->user_id = Auth::id();
        $message->post_id = $post->id;
        $message->content = $request->content;

        $message->save();
        
        return back();
    }
}