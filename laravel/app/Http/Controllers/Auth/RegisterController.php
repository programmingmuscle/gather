<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected function redirectTo()
	{
		session()->flash('success', 'サインアップしました。');

		return route('users.show', ['id' => Auth::id()]);
	}

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name'     => 'required|string|max:191',
			'email'    => 'required|string|email|max:191|unique:users',
			'password' => 'required|string|min:6|confirmed',
		], [
			'name.required'      => '選手名を入力して下さい。',
			'name.string'        => '選手名は文字列として下さい。',
			'name.max'           => '選手名は191文字以内として下さい。',
			'email.required'     => 'メールアドレスを入力して下さい。',
			'email.sring'        => 'メールアドレスは文字列として下さい。',
			'email.email'        => 'メールアドレスに「@」を挿入して下さい。',
			'email.max'          => 'メールアドレスは191文字として下さい。',
			'email.unique'       => '入力されたメールアドレスは既に使用されています。',
			'password.required'  => 'パスワードを入力して下さい。',
			'password.string'    => 'パスワードは文字列として下さい。',
			'password.min'       => 'パスワードは6文字以上として下さい。',
			'password.confirmed' => '確認用パスワードと一致していません。',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name'     => $data['name'],
			'email'    => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}
}
