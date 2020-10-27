<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserPostDeleteRequest;

class UsersController extends Controller
{
	public function index(Request $request)
	{
		$query   = User::query();
		$keyword = $request->input('keyword');

		if (!empty($keyword)) {
			$users = $query
				->where('name', 'like', '%' . $keyword . '%')
				->orWhere('residence',    'like', '%' . $keyword . '%')
				->orWhere('gender',       'like', '%' . $keyword . '%')
				->orWhere('age',          'like', '%' . $keyword . '%')
				->orWhere('experience',   'like', '%' . $keyword . '%')
				->orWhere('position',     'like', '%' . $keyword . '%')
				->orWhere('introduction', 'like', '%' . $keyword . '%')
				->orderBy('id', 'desc')
				->paginate(10);
		} else {
			$users = User::orderBy('id', 'desc')->paginate(10);
		}

		return view('users.index', [
			'users'   => $users,
			'keyword' => $keyword,
		]);
	}

	public function edit()
	{
		$user = Auth::user();

		return view('users.edit', [
			'user' => $user,
		]);
	}

	public function update(UserRequest $request)
	{
		$user = Auth::user();

		if (Hash::check($request->password, $user->password)) {
			$form = $request->except(['password', 'profile_image']);

			unset($form['_token']);

			$user->fill($form)->save();

			$profile_image = $request->file('profile_image');

			if ($request->profile_image != '') {

				$path = Storage::disk('s3')->putFile('profile_images', $profile_image, 'public');

				$user->profile_image = Storage::disk('s3')->url($path);

				$user->save();
			}

			return redirect()->route('users.show', ['id' => Auth::id()])->with('success', 'アカウントを編集しました。');
		}
	}

	public function deleteWindow()
	{
		return view('users.deleteWindow');
	}

	public function destroy(UserPostDeleteRequest $request)
	{
		$user = Auth::user();

		if (Hash::check($request->password, $user->password)) {

			$user->delete();

			return redirect('/')->with('success', 'アカウントを削除しました。');
		}
	}

	public function followers($id)
	{
		$user  = User::find($id);
		$users = $user->followers()->orderBy('id', 'desc')->paginate(10);

		return view('users.followers', [
			'users' => $users,
		]);
	}

	public function followings($id)
	{
		$user  = User::find($id);
		$users = $user->followings()->orderBy('id', 'desc')->paginate(10);

		return view('users.followings', [
			'users' => $users,
		]);
	}

	public function show($id)
	{
		$user  = User::find($id);
		$posts = $user->feed_posts()->orderBy('updated_at', 'desc')->paginate(10);
		$now   = date('Y-m-d H:i:s');

		$data = [
			'user'  => $user,
			'posts' => $posts,
			'now'   => $now,
		];

		$data += $this->counts($user);

		return view('users.show', $data);
	}

	public function showPosts($id)
	{
		$user  = User::find($id);
		$posts = $user->posts()->orderBy('updated_at', 'desc')->paginate(10);
		$now   = date('Y-m-d H:i:s');

		$data = [
			'user'  => $user,
			'posts' => $posts,
			'now'   => $now,
		];

		$data += $this->counts($user);

		return view('users.showPosts', $data);
	}

	public function showParticipations($id)
	{
		$user  = User::find($id);
		$posts = $user->participations()->orderBy('updated_at', 'desc')->paginate(10);
		$now   = date('Y-m-d H:i:s');

		$data = [
			'user'  => $user,
			'posts' => $posts,
			'now'   => $now,
		];

		$data += $this->counts($user);

		return view('users.showParticipations', $data);
	}

	public function showConcerns($id)
	{
		$user  = User::find($id);
		$posts = $user->concerns()->orderBy('updated_at', 'desc')->paginate(10);
		$now   = date('Y-m-d H:i:s');

		$data = [
			'user'  => $user,
			'posts' => $posts,
			'now'   => $now,
		];

		$data += $this->counts($user);

		return view('users.showConcerns', $data);
	}
}
