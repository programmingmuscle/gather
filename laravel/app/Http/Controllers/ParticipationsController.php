<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ParticipationsController extends Controller
{
    public function store($id)
    {
        Auth::user()->participate($id);
        return back();
    }

    public function destroy($id)
    {
        Auth::user()->cancel($id);
        return back();
    }
}
