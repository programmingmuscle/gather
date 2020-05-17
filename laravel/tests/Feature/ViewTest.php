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
        // ユーザ作成
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

        // ユーザ詳細画面(未ログイン時はフォローボタンを表示しない)
        $response = $this->get(route('users.show', ['id' => $user->id]));
        $response->assertStatus(200);
        $response->assertDontSee('フォローする');

        // アカウント削除画面(要ログイン 未ログインの場合はログイン画面にリダイレクト)
        $response = $this->get(route('users.deleteWindow', ['id' => $user->id]));
        $response->assertStatus(302);
        $response->assertRedirect('login');

        // アカウント編集画面(要ログイン 未ログインの場合はログイン画面にリダイレクト)
        $response = $this->get(route('users.edit', ['id' => $user->id]));
        $response->assertStatus(302);
        $response->assertRedirect('login');

        // 投稿一覧画面
        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);

        // 投稿詳細
        $response = $this->get(route('posts.show', ['id' => $post->id]));
        $response->assertStatus(200);

        // 投稿削除画面(要ログイン 未ログインの場合はログイン画面にリダイレクト)
        $response = $this->get(route('posts.deleteWindow', ['id' => $post->id]));
        $response->assertStatus(302);
        $response->assertRedirect('login');

        // 投稿編集画面(要ログイン 未ログインの場合はログイン画面にリダイレクト)
        $response = $this->get(route('posts.edit', ['id' => $post->id]));
        $response->assertStatus(302);
        $response->assertRedirect('login');

        // 投稿作成画面(要ログイン 未ログインの場合はログイン画面にリダイレクト)
        $response = $this->get(route('posts.create', ['id' => $user->id]));
        $response->assertStatus(302);
        $response->assertRedirect('login');

        // 存在しないページへのアクセスには404表示
        $response = $this->get('/no_route');
        $response->assertStatus(404);
    }

    // ログイン状態における各ページへのアクセスをテスト
    public function testViewAuth()
    {
        // ユーザ作成
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        // アカウント削除画面(要ログイン)
        $response = $this->actingAs($user)->get(route('users.deleteWindow', ['id' => Auth::id()]));
        $response->assertStatus(200);

        // アカウント編集画面(要ログイン)
        $response = $this->get(route('users.edit', ['id' => Auth::id()]));
        $response->assertStatus(200);

        // ユーザ詳細(要ログイン)
        $response = $this->get(route('users.show', ['id' => Auth::id()]));
        $response->assertStatus(200);
        $response->assertDontSee('フォローする');

        // 投稿削除画面(要ログイン)
        $response = $this->get(route('posts.deleteWindow', ['id' => $post->id]));
        $response->assertStatus(200);

        // 投稿編集画面(要ログイン)
        $response = $this->get(route('posts.edit', ['id' => $post->id]));
        $response->assertStatus(200);

        // 投稿作成画面(要ログイン)
        $response = $this->get(route('posts.create', ['id' => Auth::id()]));
        $response->assertStatus(200);
    }
}
