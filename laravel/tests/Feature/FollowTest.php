<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class FollowTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    // テスト開始時に未済のマイグレーションを実行 終了時にデータを削除する
    use RefreshDatabase;

    // フォローに成功するテスト
    public function testFollow()
    {
        // サインアップする
        $this->post(route('signup.post', [
            'name' => 'test',
            'email' => 'aaa@bbb.com',
            'password' => 'testPassword',
            'password_confirmation' => 'testPassword',
        ]));

        // ログイン状態をチェック ログイン状態であることを確認
        $this->assertTrue(Auth::check());

        // フォロー対象とするユーザを作成
        $user = factory(User::class)->create();

        // フォロー機能を実行
        $this->post(route('user.follow', ['id' => $user->id]));

        // フォロー機能用のテーブルにてフォロー対象idの有無を確認することでフォロー機能実行の成否を判定
        $this->assertDatabaseHas('user_follow', [
            'follow_id' => $user->id,
        ]);
    }
}
