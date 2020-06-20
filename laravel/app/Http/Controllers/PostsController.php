<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class PostsController extends Controller
{
    public function index(Request $request) {
        $query = Post::query();

        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $posts = $query
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->orwhere('date_time', 'like', '%' . $keyword . '%')
                    ->orwhere('place', 'like', '%' . $keyword . '%')
                    ->orwhere('address', 'like', '%' . $keyword . '%')
                    ->orwhere('reservation', 'like', '%' . $keyword . '%')
                    ->orwhere('expense', 'like', '%' . $keyword . '%')
                    ->orwhere('ball', 'like', '%' . $keyword . '%')
                    ->orwhere('people', 'like', '%' . $keyword . '%')
                    ->orwhere('remarks', 'like', '%' . $keyword . '%')
                    ->orderBy('id', 'disc')
                    ->paginate(10);
            $posts = Post::whereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })->orderBy('id', 'disc')->paginate(10);
            
        } else {
            $posts = Post::orderBy('id', 'disc')->paginate(10);
        }

        return view('posts.index', [
            'posts' => $posts,
            'keyword' => $keyword,
    ]);
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'year' => 'required|string|max:191',
            'month' => 'required|string|max:191',
            'day' => 'required|string|max:191',
            'from_hour' => 'required|string|max:191',
            'from_minute' => 'required|string|max:191',
            'to_hour' => 'required|string|max:191',
            'to_minute' => 'required|string|max:191',
            'place' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'reservation' => 'required|string|max:191',
            'expense' => 'required|string|max:191',
            'ball' => 'required|string|max:191',
            'deadlineYear' => 'required|string|max:191',
            'deadlineMonth' => 'required|string|max:191',
            'deadlineDay' => 'required|string|max:191',
            'deadlineHour' => 'required|string|max:191',
            'deadlineMinute' => 'required|string|max:191',
            'people' => 'required|string|max:191',
            'remarks' => 'string|nullable|max:191',
        ], 
        [
            'title.required' => 'タイトルを入力して下さい。',
            'title.string' => 'タイトルは文字列として下さい。',
            'title.max' => 'タイトルは191文字以内として下さい。',
            'year.required' => '開催年を入力して下さい。',
            'year.string' => '開催年は文字列として下さい。',
            'year.max' => '開催年は191文字以内として下さい。',
            'month.required' => '開催月を入力して下さい。',
            'month.string' => '開催月は文字列として下さい。',
            'month.max' => '開催月は191文字以内として下さい。',
            'day.required' => '開催日を入力して下さい。',
            'day.string' => '開催日は文字列として下さい。',
            'day.max' => '開催日は191文字以内として下さい。',
            'from_hour.required' => '開始時間を入力して下さい。',
            'from_hour.string' => '開始時間は文字列として下さい。',
            'from_hour.max' => '開始時間は191文字以内として下さい。',
            'from_minute.required' => '開始時間（分）を入力して下さい。',
            'from_minute.string' => '開始時間（分）は文字列として下さい。',
            'from_minute.max' => '開始時間（分）は191文字以内として下さい。',
            'to_hour.required' => '終了時間を入力して下さい。',
            'to_hour.string' => '終了時間は文字列として下さい。',
            'to_hour.max' => '終了時間は191文字以内として下さい。',
            'to_minute.required' => '終了時間（分）を入力して下さい。',
            'to_minute.string' => '終了時間（分）は文字列として下さい。',
            'to_minute.max' => '終了時間（分）は191文字以内として下さい。',
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
            'deadlineYear.required' => '締切年を入力して下さい。',
            'deadlineYear.string' => '締切年は文字列として下さい。',
            'deadlineYear.max' => '締切年は191文字以内として下さい。',
            'deadlineMonth.required' => '締切月を入力して下さい。',
            'deadlineMonth.string' => '締切月は文字列として下さい。',
            'deadlineMonth.max' => '締切月は191文字以内として下さい。',
            'deadlineDay.required' => '締切日を入力して下さい。',
            'deadlineDay.string' => '締切日は文字列として下さい。',
            'deadlineDay.max' => '締切日は191文字以内として下さい。',
            'deadlineHour.required' => '締切時間を入力して下さい。',
            'deadlineHour.string' => '締切時間は文字列として下さい。',
            'deadlineHour.max' => '締切時間は191文字以内として下さい。',
            'deadlineMinute.required' => '締切時間（分）を入力して下さい。',
            'deadlineMinute.string' => '締切時間（分）は文字列として下さい。',
            'deadlineMinute.max' => '締切時間（分）は191文字以内として下さい。',
            'people.required' => '募集人数を入力して下さい。',
            'people.string' => '募集人数は文字列として下さい。',
            'people.max' => '募集人数は191文字以内として下さい。',
            'remarks.string' => '備考は文字列として下さい。',
            'remarks.max' => '備考は191文字以内として下さい。',
        ]);     

        $request->user()->posts()->create([
            'title' => $request->title,
            'date_time' => $request->year . '/' .  $request->month . '/' .  $request->day . ' ' . $request->from_hour . ':' . $request->from_minute,
            'end_time' => $request->to_hour . ':' . $request->to_minute,
            'place' => $request->place,
            'address' => $request->address,
            'reservation' => $request->reservation,
            'expense' => $request->expense,
            'ball' => $request->ball,
            'deadline' => $request->deadlineYear . '/' . $request->deadlineMonth . '/' . $request->deadlineDay . ' ' . $request->deadlineHour . ':' . $request->deadlineMinute,
            'people' => $request->people,
            'remarks' => $request->remarks,
        ]);

        $post = Post::orderBy('id', 'disc')->first();

        return redirect()->route('posts.show', ['id' => $post->id])->with('success', '投稿を作成しました。');
    }

    public function show($id) {
        $post = Post::find($id);

        return view('posts.show', [
            'post' => $post,
        ]);
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
        $postDateTimeArray = preg_split("{[/\s:]}", $post->date_time);
        $postEndTimeArray = preg_split("{[:]}", $post->end_time);
        $postDeadlineArray = preg_split("{[/\s:]}", $post->deadline);

        return view('posts.edit', [
            'post' => $post,
            'postDateTimeArray' => $postDateTimeArray,
            'postEndTimeArray' => $postEndTimeArray,
            'postDeadlineArray' => $postDeadlineArray,
        ]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'year' => 'required|string|max:191',
            'month' => 'required|string|max:191',
            'day' => 'required|string|max:191',
            'from_hour' => 'required|string|max:191',
            'from_minute' => 'required|string|max:191',
            'to_hour' => 'required|string|max:191',
            'to_minute' => 'required|string|max:191',
            'place' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'reservation' => 'required|string|max:191',
            'expense' => 'required|string|max:191',
            'ball' => 'required|string|max:191',
            'deadlineYear' => 'required|string|max:191',
            'deadlineMonth' => 'required|string|max:191',
            'deadlineDay' => 'required|string|max:191',
            'deadlineHour' => 'required|string|max:191',
            'deadlineMinute' => 'required|string|max:191',
            'people' => 'required|string|max:191',
            'remarks' => 'string|nullable|max:191',
        ], 
        [
            'title.required' => 'タイトルを入力して下さい。',
            'title.string' => 'タイトルは文字列として下さい。',
            'title.max' => 'タイトルは191文字以内として下さい。',
            'year.required' => '開催年を入力して下さい。',
            'year.string' => '開催年は文字列として下さい。',
            'year.max' => '開催年は191文字以内として下さい。',
            'month.required' => '開催月を入力して下さい。',
            'month.string' => '開催月は文字列として下さい。',
            'month.max' => '開催月は191文字以内として下さい。',
            'day.required' => '開催日を入力して下さい。',
            'day.string' => '開催日は文字列として下さい。',
            'day.max' => '開催日は191文字以内として下さい。',
            'from_hour.required' => '開始時間を入力して下さい。',
            'from_hour.string' => '開始時間は文字列として下さい。',
            'from_hour.max' => '開始時間は191文字以内として下さい。',
            'from_minute.required' => '開始時間（分）を入力して下さい。',
            'from_minute.string' => '開始時間（分）は文字列として下さい。',
            'from_minute.max' => '開始時間（分）は191文字以内として下さい。',
            'to_hour.required' => '終了時間を入力して下さい。',
            'to_hour.string' => '終了時間は文字列として下さい。',
            'to_hour.max' => '終了時間は191文字以内として下さい。',
            'to_minute.required' => '終了時間（分）を入力して下さい。',
            'to_minute.string' => '終了時間（分）は文字列として下さい。',
            'to_minute.max' => '終了時間（分）は191文字以内として下さい。',
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
            'deadlineYear.required' => '締切年を入力して下さい。',
            'deadlineYear.string' => '締切年は文字列として下さい。',
            'deadlineYear.max' => '締切年は191文字以内として下さい。',
            'deadlineMonth.required' => '締切月を入力して下さい。',
            'deadlineMonth.string' => '締切月は文字列として下さい。',
            'deadlineMonth.max' => '締切月は191文字以内として下さい。',
            'deadlineDay.required' => '締切日を入力して下さい。',
            'deadlineDay.string' => '締切日は文字列として下さい。',
            'deadlineDay.max' => '締切日は191文字以内として下さい。',
            'deadlineHour.required' => '締切時間を入力して下さい。',
            'deadlineHour.string' => '締切時間は文字列として下さい。',
            'deadlineHour.max' => '締切時間は191文字以内として下さい。',
            'deadlineMinute.required' => '締切時間（分）を入力して下さい。',
            'deadlineMinute.string' => '締切時間（分）は文字列として下さい。',
            'deadlineMinute.max' => '締切時間（分）は191文字以内として下さい。',
            'people.required' => '募集人数を入力して下さい。',
            'people.string' => '募集人数は文字列として下さい。',
            'people.max' => '募集人数は191文字以内として下さい。',
            'remarks.string' => '備考は文字列として下さい。',
            'remarks.max' => '備考は191文字以内として下さい。',
        ]);
        
        $post = Post::find($id);
        $post->title = $request->title;
        $post->date_time = $request->year . '/' . $request->month . '/' . $request->day . ' ' . $request->from_hour . ':' . $request->from_minute;
        $post->end_time = $request->to_hour . ':'. $request->to_minute;
        $post->place = $request->place;
        $post->address = $request->address;
        $post->reservation = $request->reservation;
        $post->expense = $request->expense;
        $post->ball = $request->ball;
        $post->deadline = $request->deadlineYear . '/' . $request->deadlineMonth . '/' . $request->deadlineDay . ' ' . $request->deadlineHour . ':' . $request->deadlineMinute;
        $post->people = $request->people;
        $post->remarks = $request->remarks;
        $post->save();

        return redirect()->route('posts.show', ['id' => $post->id])->with('success', '投稿を編集しました。');
    }
}
