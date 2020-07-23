<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use Illuminate\Support\Facades\Auth;

class ParticipationsController extends Controller
{
    public function store($id)
    {  
        $post = Post::find($id);
        Auth::user()->participate($id);
        return redirect()->route('posts.show', ['id' => $post->id])->with('participate-flashmessage', '参加しました');
    }

    public function destroy($id)
    {
        Auth::user()->cancel($id);
        return back();
    }
}
