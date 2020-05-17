<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index() {
        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function show($id) {
        $user = User::find($id);

        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function edit() {
        $user = Auth::user();

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request) {      
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => [
                'required',
                'string',
                'email',
                'max:191',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'password' => [
                'required',
                function($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('パスワードが間違っています。');
                    }
                },
            ],
            'residence' => 'string|nullable|max:191',
            'gender' => 'string|nullable|max:191',
            'age' => 'string|nullable|max:191',
            'experience' => 'string|nullable|max:191',
            'position' => 'string|nullable|max:191',
            'introduction' => 'string|nullable|max:191',
        ], 
        [
            'name.required' => '選手名を入力して下さい。',
            'name.string' => '選手名は文字列として下さい。',
            'name.max' => '選手名は191文字以内として下さい。',
            'email.required' => 'メールアドレスを入力して下さい。',
            'email.sring' => 'メールアドレスは文字列として下さい。',
            'email.email' => 'メールアドレスに「@」を挿入して下さい。',
            'email.max' => 'メールアドレスは191文字として下さい。',
            'email.unique' => '入力されたメールアドレスは既に使用されています。',
            'password.required' => 'パスワードを入力して下さい。',
            'gender.string' => '性別は文字列として下さい。',
            'gender.max' => '性別は191文字以内として下さい。',
            'age.stirng' => '年齢は文字列として下さい。',
            'age.max' => '年齢は191文字以内として下さい。',
            'experience.string' => '野球歴は文字列として下さい。',
            'experience.max' => '野球歴は191文字以内として下さい。',
            'position.string' => 'ポジションは文字列として下さい。',
            'position.max' => 'ポジションは191文字以内として下さい。',
            'introduction.string' => '自己紹介は文字列として下さい。',
            'introduction.max' => '自己紹介は191文字として下さい。',
        ]);
        
        $user = Auth::user();
        
        if (Hash::check($request->password, $user->password)) {
            $form = $request->except(['password']);
            unset($form['_token']);
            $user->fill($form)->save();
            
            return redirect()->route('users.show', ['id' => Auth::id()]);
        }

        
    }

    public function deleteWindow() {
        return view('users.deleteWindow');
    }

    public function destroy(Request $request) {
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

        $user = Auth::user();

        if (Hash::check($request->password, $user->password)) {
            $user->delete();
            return redirect('/');
        }
    }
}