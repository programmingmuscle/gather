<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Post;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index(Request $request) {
        $query = User::query();

        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $users = $query
                    ->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('residence', 'like', '%' . $keyword . '%')
                    ->orWhere('gender', 'like' , '%' . $keyword . '%')
                    ->orWhere('age', 'like' , '%' . $keyword . '%')
                    ->orWhere('experience', 'like' , '%' . $keyword . '%')
                    ->orWhere('position', 'like' , '%' . $keyword . '%')
                    ->orWhere('introduction', 'like', '%' . $keyword . '%')
                    ->orderBy('id', 'disc')
                    ->paginate(10);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(10);
        }

        return view('users.index', [
            'users' => $users,
            'keyword' => $keyword,
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
            'profile_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:191',
        ], 
        [
            'name.required' => '選手名を入力して下さい。',
            'name.string' => '選手名は文字列として下さい。',
            'name.max' => '選手名は191文字以内として下さい。',
            'email.required' => 'メールアドレスを入力して下さい。',
            'email.sring' => 'メールアドレスは文字列として下さい。',
            'email.email' => 'メールアドレスに「@」を挿入して下さい。',
            'email.max' => 'メールアドレスは191文字以内として下さい。',
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
            $form = $request->except(['password', 'profile_image']);
            unset($form['_token']);
            $user->fill($form)->save();
            if ($request->profile_image != '') {
                $path = $request->profile_image->storeAs('public/profile_images', Auth::id() . '.jpg');
                $user->profile_image = $path;
                $user->save();
            }

            return redirect()->route('users.show', ['id' => Auth::id()])->with('success', 'アカウントを編集しました。');
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
            return redirect('/')->with('success', 'アカウントを削除しました。');
        }
    }

    public function followers($id)
    {
        $user = User::find($id);
        $users = $user->followers()->orderBy('id', 'desc')->paginate(10);

        return view('users.followers', [
            'users' => $users,
        ]);
    }

    public function followings($id)
    {
        $user = User::find($id);
        $users = $user->followings()->orderBy('id', 'desc')->paginate(10);

        return view('users.followings', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $timelines = $user->feed_posts()->orderBy('id', 'desc')->paginate(10);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $participations = $user->participations()->orderBy('id', 'desc')->paginate(10);
        $concerns = $user->concerns()->orderBy('id', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'timelines' => $timelines,
            'posts' => $posts,
            'participations' => $participations,
            'concerns' => $concerns,
        ];

        $data += $this->counts($user);

        return view('users.show', $data);
    }
}