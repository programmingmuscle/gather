<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class PostsController extends Controller
{
    public function index(Request $request) {
        
        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $posts = Post::            
                    join('users',  'users.id' , 'posts.user_id')
                    ->select(['users.id as userId', 'users.name', 'users.profile_image', 'users.created_at as usersCreated_at', 'users.updated_at as usersUpdated_at', 'posts.id', 'posts.title', 'posts.date_time', 'posts.end_time', 'posts.place', 'posts.address', 'posts.reservation', 'posts.expense', 'posts.ball', 'posts.deadline', 'posts.people', 'posts.remarks', 'posts.created_at', 'posts.updated_at'])
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->orwhere('date_time', 'like', '%' . $keyword . '%')
                    ->orwhere('place', 'like', '%' . $keyword . '%')
                    ->orwhere('address', 'like', '%' . $keyword . '%')
                    ->orwhere('reservation', 'like', '%' . $keyword . '%')
                    ->orwhere('expense', 'like', '%' . $keyword . '%')
                    ->orwhere('ball', 'like', '%' . $keyword . '%')
                    ->orwhere('people', 'like', '%' . $keyword . '%')
                    ->orwhere('remarks', 'like', '%' . $keyword . '%')
                    ->orwhere('name', 'like', '%' . $keyword . '%')
                    ->orderBy('posts.updated_at', 'desc')
                    ->paginate(10);     
        } else {
            $posts = Post::         
                    join('users',  'users.id' , 'posts.user_id')
                    ->select(['users.id as userId', 'users.name', 'users.profile_image', 'users.created_at as usersCreated_at', 'users.updated_at as usersUpdated_at', 'posts.id', 'posts.title', 'posts.date_time', 'posts.end_time', 'posts.place', 'posts.address', 'posts.reservation', 'posts.expense', 'posts.ball', 'posts.deadline', 'posts.people', 'posts.remarks', 'posts.created_at', 'posts.updated_at'])
                    ->orderBy('posts.updated_at', 'desc')
                    ->paginate(10); 
        }

        $now = date('Y/n/j G:i');

        return view('posts.index', [
            'posts' => $posts,
            'keyword' => $keyword,
            'now' => $now,
    ]);
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'date_time' => 'required|date|max:191',
            'end_time' => 'required|date|after:date_time|max:191',
            'place' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'reservation' => 'required|string|max:191',
            'expense' => 'required|string|max:191',
            'ball' => 'required|string|max:191',
            'deadline' => 'required|date|before:date_time|max:191',
            'people' => 'required|string|max:191',
            'remarks' => 'string|nullable|max:191',
        ], 
        [
            'title.required' => 'タイトルを入力して下さい。',
            'title.string' => 'タイトルは文字列として下さい。',
            'title.max' => 'タイトルは191文字以内として下さい。',
            'date_time.required' => '開始日時を入力して下さい。',
            'date_time.date' => '開始日時は日付の文字列として下さい。',
            'date_time.max' => '開始日時は191文字以内として下さい。',
            'end_time.required' => '終了日時を入力して下さい。',
            'end_time.date' => '終了日時は日付の文字列として下さい。',
            'end_time.after' => '終了日時は開始日時より後の日時として下さい。',
            'end_time.max' => '終了日時は191文字以内として下さい。',
            'place.required' => '場所を入力して下さい。',
            'place.string' => '場所は文字列として下さい。',
            'place.max' => '場所は191文字以内として下さい。',
            'address.required' => '住所を入力して下さい。',
            'address.string' => '住所は文字列として下さい。',
            'address.max' => '住所は191文字以内として下さい。',
            'reservation.required' => '場所予約を入力して下さい。',
            'reservation.stirng' => '場所予約は文字列として下さい。',
            'reservation.max' => '場所予約は191文字以内として下さい。',
            'expense.required' => '参加費用を入力して下さい。',
            'expense.string' => '参加費用は文字列として下さい。',
            'expense.max' => '参加費用は191文字以内として下さい。',
            'ball.required' => '使用球を入力して下さい。',
            'ball.string' => '使用球は文字列として下さい。',
            'ball.max' => '使用球は191文字以内として下さい。',  
            'deadline.required' => '締切日時を入力して下さい。',
            'deadline.date' => '締切日時は日付の文字列として下さい。',
            'deadline.before' => '締切日時は開始日時より前の日時として下さい。',
            'deadline.max' => '締切日時は191文字以内として下さい。',
            'people.required' => '募集人数を入力して下さい。',
            'people.string' => '募集人数は文字列として下さい。',
            'people.max' => '募集人数は191文字以内として下さい。',
            'remarks.string' => '備考は文字列として下さい。',
            'remarks.max' => '備考は191文字以内として下さい。',
        ]);

        $request->user()->posts()->create([
            'title' => $request->title,
            'date_time' => $request->date_time,
            'end_time' => $request->end_time,
            'place' => $request->place,
            'address' => $request->address,
            'reservation' => $request->reservation,
            'expense' => $request->expense,
            'ball' => $request->ball,
            'deadline' => $request->deadline,
            'people' => $request->people,
            'remarks' => $request->remarks,
        ]);

        $post = Post::orderBy('id', 'disc')->first();

        return redirect()->route('posts.show', ['id' => $post->id])->with('success', '投稿を作成しました。');
    }

    public function show($id) {
        $post = Post::find($id);
        $users = $post->participate_users()->orderBy('id', 'desc')->get();
        $messages = $post->messages()->orderBy('id', 'desc')->get();
        $count_participate_users = $post->participate_users()->count();
        $now = date('Y/n/j G:i');

        return view('posts.show', [
            'post' => $post,
            'users' => $users,
            'messages' => $messages,
            'count_participate_users' => $count_participate_users,
            'now' => $now,
        ]);
    }

    public function getData($id)
    {
        $post = Post::find($id);
        $messages = $post->messages()->orderBy('id', 'desc')->get();
        $json = ["messages" => $messages];
        return response()->json($json);
    }

    public function deleteWindow($id) {
        $post = Post::find($id);

        return view('posts.deleteWindow', [
            'post' => $post,
        ]);
    }

    public function destroy(Request $request, $id) {
        $this->validate($request, [
            'password' => [
                'required',
                function($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('パスワードが間違っています。');
                    }
                },
            ],
        ], 
        [
            'password.required' => 'パスワードを入力して下さい。',
        ]);

        $post = Post::find($id);

        if (Hash::check($request->password, Auth::user()->password)) {
            $post->delete();

            return redirect()->route('users.show', ['id' => Auth::id()])->with('success', '投稿を削除しました。');
        }
    }

    public function edit($id) {
        $post = Post::find($id);

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'title' => 'required|string|max:191',
            'date_time' => 'required|date|max:191',
            'end_time' => 'required|date|after:date_time|max:191',
            'place' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'reservation' => 'required|string|max:191',
            'expense' => 'required|string|max:191',
            'ball' => 'required|string|max:191',
            'deadline' => 'required|date|before:date_time|max:191',
            'people' => 'required|string|max:191',
            'remarks' => 'string|nullable|max:191',
        ], 
        [
            'title.required' => 'タイトルを入力して下さい。',
            'title.string' => 'タイトルは文字列として下さい。',
            'title.max' => 'タイトルは191文字以内として下さい。',
            'date_time.required' => '開始日時を入力して下さい。',
            'date_time.date' => '開始日時は日付の文字列として下さい。',
            'date_time.max' => '開始日時は191文字以内として下さい。',
            'end_time.required' => '終了日時を入力して下さい。',
            'end_time.date' => '終了日時は日付の文字列として下さい。',
            'end_time.after' => '終了日時は開始日時より後の日時として下さい。',
            'end_time.max' => '終了日時は191文字以内として下さい。',
            'place.required' => '場所を入力して下さい。',
            'place.string' => '場所は文字列として下さい。',
            'place.max' => '場所は191文字以内として下さい。',
            'address.required' => '住所を入力して下さい。',
            'address.string' => '住所は文字列として下さい。',
            'address.max' => '住所は191文字以内として下さい。',
            'reservation.required' => '場所予約を入力して下さい。',
            'reservation.stirng' => '場所予約は文字列として下さい。',
            'reservation.max' => '場所予約は191文字以内として下さい。',
            'expense.required' => '参加費用を入力して下さい。',
            'expense.string' => '参加費用は文字列として下さい。',
            'expense.max' => '参加費用は191文字以内として下さい。',
            'ball.required' => '使用球を入力して下さい。',
            'ball.string' => '使用球は文字列として下さい。',
            'ball.max' => '使用球は191文字以内として下さい。',  
            'deadline.required' => '締切日時を入力して下さい。',
            'deadline.date' => '締切日時は日付の文字列として下さい。',
            'deadline.before' => '締切日時は開始日時より前の日時として下さい。',
            'deadline.max' => '締切日時は191文字以内として下さい。',
            'people.required' => '募集人数を入力して下さい。',
            'people.string' => '募集人数は文字列として下さい。',
            'people.max' => '募集人数は191文字以内として下さい。',
            'remarks.string' => '備考は文字列として下さい。',
            'remarks.max' => '備考は191文字以内として下さい。',
        ]);
        
        $post = Post::find($id);
        $post->title = $request->title;
        $post->date_time = $request->date_time;
        $post->end_time = $request->end_time;
        $post->place = $request->place;
        $post->address = $request->address;
        $post->reservation = $request->reservation;
        $post->expense = $request->expense;
        $post->ball = $request->ball;
        $post->deadline = $request->deadline;
        $post->people = $request->people;
        $post->remarks = $request->remarks;
        $post->save();

        return redirect()->route('posts.show', ['id' => $post->id])->with('success', '投稿を編集しました。');
    }

    public function participateUsers($id)
    {
        $post = Post::find($id);
        $users = $post->participate_users()->orderBy('id', 'desc')->paginate(10);

        return view('posts.participate_users', [
            'users' => $users,
        ]);
    }
}
