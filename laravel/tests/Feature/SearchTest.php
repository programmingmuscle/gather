<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class SearchTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */

	// ユーザ検索に成功するテスト
	public function testSearchUsers()
	{
		// ユーザ１を作成
		factory(User::class)->create([
			'introduction' => 'testSearchUsersIntroductionInvisible',
		]);

		// ユーザ２を作成
		factory(User::class)->create([
			'name' => 'testSearchUsersNameVisible',
			'introduction' => 'testSearchUsersIntroductionVisible',
		]);

		// ユーザ一覧画面へアクセス
		$response = $this->get(route('users.index'));

		// ユーザ１及び２のデータが表示されていることを確認
		$response->assertSee('testSearchUsersIntroductionInvisible')
			->assertSee('testSearchUsersNameVisible')
			->assertSee('testSearchUsersIntroductionVisible');

		// 検索キーワードを入力しサブミット
		$response = $this->get(route('users.index', [
			'keyword' => 'testSearchUsersIntroductionVisible',
		]));

		// ユーザ一覧画面にてユーザ２のデータのみが表示されていることを確認
		$response->assertSee('testSearchUsersNameVisible')
			->assertDontSee('testSearchUsersIntroductionInvisible');
	}

	// 投稿検索に成功するテスト
	public function testSearchPosts()
	{
		// 投稿１を作成
		factory(Post::class)->create([
			'remarks' => 'testSearchPostsRemarksInvisible',
		]);

		// 投稿２を作成
		factory(Post::class)->create([
			'title' => 'testSearchPostsTitleVisible',
			'remarks' => 'testSearchPostsRemarksVisible',
		]);

		// 投稿一覧画面へアクセス
		$response = $this->get(route('posts.index'));

		// 投稿１及び２のデータが表示されていることを確認
		$response->assertSee('testSearchPostsRemarksInvisible')
			->assertSee('testSearchPostsTitleVisible')
			->assertSee('testSearchPostsRemarksVisible');

		// 検索キーワードを入力しサブミット
		$response = $this->get(route('posts.index', [
			'keyword' => 'testSearchPostsRemarksVisible',
		]));

		// 投稿一覧画面にて投稿２のデータのみが表示されていることを確認
		$response->assertSee('testSearchPostsTitleVisible')
			->assertDontSee('testSearchPostsRemarksInvisible');
	}
}
