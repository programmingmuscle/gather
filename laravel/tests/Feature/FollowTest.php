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

    // フォロー機能実行後にフォロー取り止め機能を行い成功するテスト
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

        // user_followテーブルにてフォロー機能の対象としたidの有無を確認することでフォロー機能実行の成否を判定
        $this->assertDatabaseHas('user_follow', [
            'follow_id' => $user->id,
        ]);

        // フォロー取り止め機能を実行
        $this->delete(route('user.unfollow', ['follow_id' => $user->id]));

        // user_followテーブルにてフォロー機能の対象としたidの有無を確認することでフォロー取り止め機能実行の成否を判定
        $this->assertDatabaseMissing('user_follow', [
            'follow_id' => $user->id,
        ]);
    }

    // アカウント削除時に該当アカウントへのフォローが取り止められていることを確認
    public function testFollowDeleteAccount()
    {
        // サインアップする
        $this->post(route('signup.post', [
            'name' => 'test',
            'email' => 'followDeleteAccount@bbb.com',
            'password' => 'testFollowDeleteAccount',
            'password_confirmation' => 'testFollowDeleteAccount',
        ]));

        // ログイン状態をチェック ログイン状態であることを確認
        $this->assertTrue(Auth::check());
        
        // フォロー対象とするユーザを作成
        $user = factory(User::class)->create();

        // フォロー機能を実行
        $this->post(route('user.follow', ['id' => $user->id]));

        // user_followテーブルにてフォロー機能の対象としたidの有無を確認することでフォロー機能実行の成否を判定
        $this->assertDatabaseHas('user_follow', [
            'follow_id' => $user->id,
        ]);

        $userId = Auth::id();

        // アカウントを削除
        $this->delete("/users/{$userId}", [
            'password' => 'testFollowDeleteAccount',
        ]);

        // user_followテーブルにてフォロー機能の対象としたidの有無を確認することでフォロー機能が取り止められていることを確認
        $this->assertDatabaseMissing('user_follow', [
            'follow_id' => $user->id,
        ]);
    }
}
