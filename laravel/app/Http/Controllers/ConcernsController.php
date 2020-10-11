<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConcernsController extends Controller
{
	public function store($id)
	{
		Auth::user()->concern($id);

		return back();
	}

	public function destroy($id)
	{
		Auth::user()->unconcern($id);

		return back();
	}
}
