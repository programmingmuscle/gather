<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class ParticipateTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	// テスト開始時に未済のマイグレーションを実行 終了時にデータを削除する
	use RefreshDatabase;

	// 参加する機能実行後に参加取り止め機能を行い成功するテスト
	public function testParticipate()
	{
		// ユーザを作成
		$user = factory(User::class)->create();

		// 参加する対象とする投稿を作成
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

		// 参加する機能を実行 実行後は投稿詳細へ画面遷移する
		$response = $this->post(route('participations.participate', ['id' => $post->id]));
		$response->assertRedirect(route('posts.show', ['id' => $post->id]));

		// participationsテーブルにて参加する機能の対象としたidの有無を確認することで気になる機能実行の成否を判定
		$this->assertDatabaseHas('participations', [
			'post_id' => $post->id,
		]);

		// 参加する取り止め機能を実行
		$this->delete(route('participations.cancel', ['id' => $post->id]));

		// participationsテーブルにて参加する機能の対象としたidの有無を確認することで参加取り止め機能実行の成否を判定
		$this->assertDatabaseMissing('participations', [
			'post_id' => $post->id,
		]);
	}

	// 投稿削除時に該当する投稿への参加が取り止められていることを確認
	public function testParticipationDeleteAccount()
	{
		// 参加対象とする投稿を作成
		$post = factory(Post::class)->create();

		// ユーザを作成
		$user = factory(User::class)->create([
			'password' => bcrypt('testParticipationDeletePost'),
		]);

		// $userでログインして参加機能を実行
		$this->actingAs($user)->post(route('participations.participate', ['id' => $post->id]));

		// participationsテーブルにて参加機能の対象としたidの有無を確認することで参加機能実行の成否を判定
		$this->assertDatabaseHas('participations', [
			'post_id' => $post->id,
		]);

		$postId = $post->id;

		// 投稿を削除
		$this->delete("/posts/{$postId}", [
			'password' => 'testParticipationDeletePost',
		]);

		// participationsテーブルにて参加機能の対象としたidの有無を確認することで参加機能が取り止められていることを確認
		$this->assertDatabaseMissing('participations', [
			'post_id' => $post->id,
		]);
	}
}
