<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UserPostDeleteRequest;

class PostsController extends Controller
{
	public function index(Request $request)
	{

		$keyword = $request->input('keyword');

		if (!empty($keyword)) {
			$posts = Post::join('users',  'users.id', 'posts.user_id')
				->select(['users.id as userId', 'users.name', 'users.profile_image', 'users.created_at as usersCreated_at', 'users.updated_at as usersUpdated_at', 'posts.id', 'posts.title', 'posts.date_time', 'posts.end_time', 'posts.place', 'posts.address', 'posts.reservation', 'posts.expense', 'posts.ball', 'posts.deadline', 'posts.people', 'posts.remarks', 'posts.created_at', 'posts.updated_at'])
				->where('title', 'like', '%' . $keyword . '%')
				->orwhere('date_time',    'like', '%' . $keyword . '%')
				->orwhere('place',        'like', '%' . $keyword . '%')
				->orwhere('address',      'like', '%' . $keyword . '%')
				->orwhere('reservation',  'like', '%' . $keyword . '%')
				->orwhere('expense',      'like', '%' . $keyword . '%')
				->orwhere('ball',         'like', '%' . $keyword . '%')
				->orwhere('people',       'like', '%' . $keyword . '%')
				->orwhere('remarks',      'like', '%' . $keyword . '%')
				->orwhere('name',         'like', '%' . $keyword . '%')
				->orderBy('posts.updated_at', 'desc')
				->paginate(10);
		} else {
			$posts = Post::join('users',  'users.id', 'posts.user_id')
				->select(['users.id as userId', 'users.name', 'users.profile_image', 'users.created_at as usersCreated_at', 'users.updated_at as usersUpdated_at', 'posts.id', 'posts.title', 'posts.date_time', 'posts.end_time', 'posts.place', 'posts.address', 'posts.reservation', 'posts.expense', 'posts.ball', 'posts.deadline', 'posts.people', 'posts.remarks', 'posts.created_at', 'posts.updated_at'])
				->orderBy('posts.updated_at', 'desc')
				->paginate(10);
		}

		$now = date('Y-m-d H:i:s');

		return view('posts.index', [
			'posts'   => $posts,
			'keyword' => $keyword,
			'now'     => $now,
		]);
	}

	public function create()
	{
		return view('posts.create');
	}

	public function store(PostRequest $request)
	{
		$request->user()->posts()->create([
			'title'       => $request->title,
			'date_time'   => $request->date_time,
			'end_time'    => $request->end_time,
			'place'       => $request->place,
			'address'     => $request->address,
			'reservation' => $request->reservation,
			'expense'     => $request->expense,
			'ball'        => $request->ball,
			'deadline'    => $request->deadline,
			'people'      => $request->people,
			'remarks'     => $request->remarks,
		]);

		$post = Post::orderBy('id', 'desc')->first();

		return redirect()->route('posts.show', ['id' => $post->id])->with('success', '投稿を作成しました。');
	}

	public function show($id)
	{
		$post                    = Post::find($id);
		$users                   = $post->participate_users()->orderBy('id', 'desc')->get();
		$messages                = $post->messages()->orderBy('id', 'desc')->get();
		$count_participate_users = $post->participate_users()->count();
		$now                     = date('Y-m-d H:i:s');

		return view('posts.show', [
			'post'                    => $post,
			'users'                   => $users,
			'messages'                => $messages,
			'count_participate_users' => $count_participate_users,
			'now'                     => $now,
		]);
	}

	public function getDataParticipateUsers($id)
	{
		$post                    = Post::find($id);
		$participate_users       = $post->participate_users()->orderBy('id', 'desc')->get();
		$count_participate_users = $post->participate_users()->count();

		$json = [
			"post"                    => $post,
			"participate_users"       => $participate_users,
			"count_participate_users" => $count_participate_users,
		];

		return response()->json($json);
	}

	public function getDataMessages($id)
	{
		$post     = Post::find($id);
		$messages = $post->messages()->orderBy('id', 'desc')->get();

		$json = ["messages" => $messages];

		return response()->json($json);
	}

	public function deleteWindow($id)
	{
		$post = Post::find($id);

		return view('posts.deleteWindow', [
			'post' => $post,
		]);
	}

	public function destroy(UserPostDeleteRequest $request, $id)
	{
		$post = Post::find($id);

		if (Hash::check($request->password, Auth::user()->password)) {
			$post->delete();

			return redirect()->route('users.show', ['id' => Auth::id()])->with('success', '投稿を削除しました。');
		}
	}

	public function edit($id)
	{
		$post = Post::find($id);

		return view('posts.edit', [
			'post' => $post,
		]);
	}

	public function update(PostRequest $request, $id)
	{
		$post = Post::find($id);

		$post->title       = $request->title;
		$post->date_time   = $request->date_time;
		$post->end_time    = $request->end_time;
		$post->place       = $request->place;
		$post->address     = $request->address;
		$post->reservation = $request->reservation;
		$post->expense     = $request->expense;
		$post->ball        = $request->ball;
		$post->deadline    = $request->deadline;
		$post->people      = $request->people;
		$post->remarks     = $request->remarks;

		$post->save();

		return redirect()->route('posts.show', ['id' => $post->id])->with('success', '投稿を編集しました。');
	}

	public function participateUsers($id)
	{
		$post  = Post::find($id);
		$users = $post->participate_users()->orderBy('id', 'desc')->paginate(10);

		return view('posts.participate_users', [
			'users' => $users,
		]);
	}
}
