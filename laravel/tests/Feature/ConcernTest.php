<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class ConcernTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // テスト開始時に未済のマイグレーションを実行 終了時にデータを削除する
    use RefreshDatabase;

    // 気になる機能実行後に気になる取り止め機能を行い成功するテスト
    public function testConcern()
    {
        // ユーザを作成
        $user = factory(User::class)->create();

        // 気になる対象とする投稿を作成
        $post = factory(Post::class)->create();

        // サインアップする
        $this->post(route('signup.post', [
            'name' => 'test',
            'email' => 'aaa@bbb.com',
            'password' => 'testPassword',
            'password_confirmation' => 'testPassword',
        ]));

        // ログイン状態をチェック ログイン状態であることを確認
        $this->assertTrue(Auth::check());
        
        // 気になる機能を実行
        $this->post(route('concerns.concern', ['id' => $post->id]));

        // Concernsテーブルにて気になる機能の対象としたidの有無を確認することで気になる機能実行の成否を判定
        $this->assertDatabaseHas('concerns', [
            'post_id' => $post->id,
        ]);

        // 気になる取り止め機能を実行
        $this->delete(route('concerns.unconcern', ['id' => $post->id]));

        // concernsテーブルにて気になる機能の対象としたidの有無を確認することで気になる取り止め機能実行の成否を判定
        $this->assertDatabaseMissing('concerns', [
            'post_id' => $post->id,
        ]);
    }
}
