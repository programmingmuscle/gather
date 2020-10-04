<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserFollowController extends Controller
{
	public function store($id)
	{
		Auth::user()->follow($id);

		return back();
	}

	public function destroy($id)
	{
		Auth::user()->unfollow($id);

		return back();
	}

	public function getData($id)
	{
		$user = User::find($id);

		$count_followers = $user->followers()->count();

		$json = ["count_followers" => $count_followers];

		return response()->json($json);
	}
}
