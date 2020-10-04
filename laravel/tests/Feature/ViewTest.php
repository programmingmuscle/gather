<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;

class ViewTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */

	// テスト開始時に未済のマイグレーションを実行 終了時にデータを削除する
	use RefreshDatabase;

	// 未ログイン状態における各ページへのアクセスをテスト
	public function testView()
	{
		// ユーザ及び投稿を作成
		$user = factory(User::class)->create();
		$post = factory(Post::class)->create();

		// ホーム画面
		$response = $this->get('/');
		$response->assertStatus(200);

		// ログイン画面
		$response = $this->get('login');
		$response->assertStatus(200);

		// サインアップ画面
		$response = $this->get('signup');
		$response->assertStatus(200);

		// ユーザ一覧画面
		$response = $this->get('users');
		$response->assertStatus(200);

		// ユーザ詳細
		$response = $this->get(route('users.show', ['id' => $user->id]));
		$response->assertStatus(200);

		// アカウント削除画面(未ログインの場合はログイン画面にリダイレクト)
		$response = $this->get(route('users.deleteWindow', ['id' => $user->id]));
		$response->assertStatus(302)
			->assertRedirect('login');

		// アカウント編集画面(未ログインの場合はログイン画面にリダイレクト)
		$response = $this->get(route('users.edit', ['id' => $user->id]));
		$response->assertStatus(302)
			->assertRedirect('login');

		// 投稿一覧画面
		$response = $this->get(route('posts.index'));
		$response->assertStatus(200);

		// 投稿詳細
		$response = $this->get(route('posts.show', ['id' => $post->id]));
		$response->assertStatus(200);

		// フォロー一覧画面
		$response = $this->get(route('users.followings', ['id' => $user->id]));
		$response->assertStatus(200);

		// フォロワー一覧画面
		$response = $this->get(route('users.followers', ['id' => $user->id]));
		$response->assertStatus(200);

		// 参加者一覧画面
		$response = $this->get(route('posts.participateUsers', ['id' => $post->id]));
		$response->assertStatus(200);

		// 投稿削除画面(未ログインの場合はログイン画面にリダイレクト)
		$response = $this->get(route('posts.deleteWindow', ['id' => $post->id]));
		$response->assertStatus(302)
			->assertRedirect('login');

		// 投稿編集画面(未ログインの場合はログイン画面にリダイレクト)
		$response = $this->get(route('posts.edit', ['id' => $post->id]));
		$response->assertStatus(302)
			->assertRedirect('login');

		// 投稿作成画面(未ログインの場合はログイン画面にリダイレクト)
		$response = $this->get(route('posts.create', ['id' => $user->id]));
		$response->assertStatus(302)
			->assertRedirect('login');

		// 存在しないページへのアクセスには404表示
		$response = $this->get('/no_route');
		$response->assertStatus(404);
	}

	// ログイン状態におけるログインを要するページへのアクセスをテスト
	public function testViewAuth()
	{
		// ユーザ及び投稿を作成
		$user = factory(User::class)->create();
		$post = factory(Post::class)->create();

		// アカウント削除画面
		$response = $this->actingAs($user)->get(route('users.deleteWindow', ['id' => Auth::id()]));
		$response->assertStatus(200);

		// アカウント編集画面
		$response = $this->get(route('users.edit', ['id' => Auth::id()]));
		$response->assertStatus(200);

		// 投稿削除画面
		$response = $this->get(route('posts.deleteWindow', ['id' => $post->id]));
		$response->assertStatus(200);

		// 投稿編集画面
		$response = $this->get(route('posts.edit', ['id' => $post->id]));
		$response->assertStatus(200);

		// 投稿作成画面
		$response = $this->get(route('posts.create', ['id' => Auth::id()]));
		$response->assertStatus(200);
	}
}
