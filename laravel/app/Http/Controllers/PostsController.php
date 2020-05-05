<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index', [
            'posts' => $posts]);
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'date_time' => 'required|string|max:191',
            'place' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'reservation' => 'required|string|max:191',
            'expense' => 'required|string|max:191',
            'ball' => 'required|string|max:191',
            'deadline' => 'required|string|max:191',
            'people' => 'required|string|max:191',
            'remarks' => 'string|nullable|max:191',
        ], 
        [
            'title.required' => 'タイトルを入力して下さい。',
            'title.string' => 'タイトルは文字列として下さい。',
            'title.max' => 'タイトルは191文字以内として下さい。',
            'date_time.required' => '日時を入力して下さい。',
            'date_time.string' => '日時は文字列として下さい。',
            'date_time.max' => '日時は191文字として下さい。',
            'place.required' => '場所を入力して下さい。',
            'place.string' => '場所は文字列として下さい。',
            'place.max' => '場所は191文字以内として下さい。',
            'address.required' => '住所を入力して下さい。',
            'address.string' => '住所は文字列として下さい。',
            'address.max' => '住所は191文字以内として下さい。',
            'reservation.required' => '場所予約は文字列として下さい。',
            'reservation.stirng' => '場所予約は文字列として下さい。',
            'reservation.max' => '場所予約は191文字以内として下さい。',
            'expense.required' => '参加費用を入力して下さい。',
            'expense.string' => '参加費用は文字列として下さい。',
            'expense.max' => '参加費用は191文字以内として下さい。',
            'ball.required' => '使用球を入力して下さい。',
            'ball.string' => '使用球は文字列として下さい。',
            'ball.max' => '使用球は191文字以内として下さい。',
            'deadline.required' => '応募締切を入力して下さい。',
            'deadline.string' => '応募締切は文字列として下さい。',
            'deadline.max' => '応募締切は191文字以内として下さい。',
            'people.required' => '募集人数を入力して下さい。',
            'people.string' => '募集人数は文字列として下さい。',
            'people.max' => '募集人数は191文字以内として下さい。',
            'remarks.string' => '備考は文字列として下さい。',
            'remarks.max' => '備考は191文字以内として下さい。',
        ]);

        $request->user()->posts()->create([
            'title' => $request->title,
            'date_time' => $request->date_time,
            'place' => $request->place,
            'address' => $request->address,
            'reservation' => $request->reservation,
            'expense' => $request->expense,
            'ball' => $request->ball,
            'deadline' => $request->deadline,
            'people' => $request->people,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('users.show', ['id' => Auth::id()]);
    }
}
