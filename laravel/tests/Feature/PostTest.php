<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class PostTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */

	use RefreshDatabase;

	// 投稿作成時に係るエラー発生時の挙動をテスト
	public function testPostError()
	{
		// ユーザを作成
		$user = factory(User::class)->create();

		// $userでログインして投稿作成
		$response = $this->actingAs($user)->post(route('posts.store', [
			'title' => '',
			'date_time' => '',
			'end_time' => '',
			'place' => '',
			'address' => '',
			'reservation' => '',
			'expense' => '',
			'ball' => '',
			'deadline' => '',
			'people' => '',
			'remarks' => 'nullError'
		]));

		// 上記投稿作成時の入力必須項目において空欄となっていたものについてセッションにエラーデータが存在していることを確認
		$response->assertSessionHasErrors(['title', 'date_time', 'end_time', 'place', 'address', 'reservation', 'expense', 'ball', 'deadline', 'people']);

		// 各項目のエラーに対して正しいエラーメッセージが存在していることを確認
		$this->assertEquals(
			'タイトルを入力して下さい。',
			session('errors')->first('title')
		);
		$this->assertEquals(
			'開始日時を入力して下さい。',
			session('errors')->first('date_time')
		);
		$this->assertEquals(
			'終了日時を入力して下さい。',
			session('errors')->first('end_time')
		);
		$this->assertEquals(
			'場所を入力して下さい。',
			session('errors')->first('place')
		);
		$this->assertEquals(
			'住所を入力して下さい。',
			session('errors')->first('address')
		);
		$this->assertEquals(
			'場所予約を入力して下さい。',
			session('errors')->first('reservation')
		);
		$this->assertEquals(
			'参加費用を入力して下さい。',
			session('errors')->first('expense')
		);
		$this->assertEquals(
			'使用球を入力して下さい。',
			session('errors')->first('ball')
		);
		$this->assertEquals(
			'締切日時を入力して下さい。',
			session('errors')->first('deadline')
		);
		$this->assertEquals(
			'募集人数を入力して下さい。',
			session('errors')->first('people')
		);

		// 上記投稿がデータベースに保存されていないことを確認
		$this->assertDatabaseMissing('posts', [
			'remarks' => 'nullError',
		]);

		// 192文字の文字列を作成
		$badRemarks = str_repeat('123', '64');

		// 再度投稿作成
		$response = $this->post(route('posts.store', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => $badRemarks,
		]));

		// 上記投稿作成時のremarksカラムにおいて191文字を超えたことによりセッションにエラーデータが存在していることを確認
		$response->assertSessionHasErrors('remarks');

		// 正しいエラーメッセージが存在していることを確認
		$this->assertEquals(
			'備考は191文字以内として下さい。',
			session('errors')->first('remarks')
		);

		// 上記投稿がデータベースに保存されていないことを確認
		$this->assertDatabaseMissing('posts', [
			'remarks' => $badRemarks,
		]);
	}

	// 投稿作成に成功するテスト
	public function testPost()
	{
		// ユーザを作成
		$user = factory(User::class)->create();

		// $userでログインして投稿作成
		$response = $this->actingAs($user)->post(route('posts.store', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarks',
		]));

		// データベースに上記投稿が保存されていることを確認
		$this->assertDatabaseHas('posts', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarks',
		]);

		// 上記投稿を選択して変数に代入
		$posts = new Post;
		$post = $posts->where('remarks', 'testRemarks')->first();

		// 投稿作成後に投稿詳細画面にリダイレクトされていることを確認
		$response->assertRedirect(route('posts.show', ['id' => $post->id]));

		// 投稿詳細画面に上記投稿が表示されることを確認
		$response = $this->get(route('posts.show', ['id' => $post->id]));
		$response->assertSee('投稿詳細')
			->assertSee('testTitle')
			->assertSee('2020/2/2 0:00')
			->assertSee('2020/2/2 0:30')
			->assertSee('testPlace')
			->assertSee('testAddress')
			->assertSee('不要')
			->assertSee('testExpense')
			->assertSee('軟式')
			->assertSee('2020/2/1 0:00')
			->assertSee('1')
			->assertSee('testRemarks');

		// 投稿一覧画面に遷移して上記投稿が表示されることを確認
		$response = $this->get(route('posts.index'));
		$response->assertSee('testTitle')
			->assertSee('2020/2/2 0:00')
			->assertSee('2020/2/2 0:30')
			->assertSee('testPlace')
			->assertSee('testAddress')
			->assertSee('不要')
			->assertSee('testExpense')
			->assertSee('軟式')
			->assertSee('2020/2/1 0:00')
			->assertSee('1')
			->assertSee('testRemarks');
	}

	// 投稿編集時に係るエラー発生時の挙動をテスト
	public function testPostEditError()
	{
		// ユーザを作成
		$user = factory(User::class)->create();

		// $userでログインして投稿作成
		$response = $this->actingAs($user)->post(route('posts.store', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarksEditError',
		]));

		// データベースに上記投稿が保存されていることを確認
		$this->assertDatabaseHas('posts', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarksEditError',
		]);

		// 上記投稿を選択して変数にidを代入
		$posts = new Post;
		$post = $posts->where('remarks', 'testRemarksEditError')->first();
		$postId = $post->id;

		// 上記投稿を編集する('remarks'を編集)
		$response = $this->put("/posts/{$postId}", [
			'title' => '',
			'date_time' => '',
			'end_time' => '',
			'place' => '',
			'address' => '',
			'reservation' => '',
			'expense' => '',
			'ball' => '',
			'deadline' => '',
			'people' => '',
		]);

		// 投稿編集時の入力必須項目において空欄となっていたものについてセッションにエラーデータが存在していることを確認
		$response->assertSessionHasErrors(['title', 'date_time', 'end_time', 'place', 'address', 'reservation', 'expense', 'ball', 'deadline', 'people']);

		// 各項目のエラーに対して正しいエラーメッセージが存在していることを確認
		$this->assertEquals(
			'タイトルを入力して下さい。',
			session('errors')->first('title')
		);
		$this->assertEquals(
			'開始日時を入力して下さい。',
			session('errors')->first('date_time')
		);
		$this->assertEquals(
			'終了日時を入力して下さい。',
			session('errors')->first('end_time')
		);
		$this->assertEquals(
			'場所を入力して下さい。',
			session('errors')->first('place')
		);
		$this->assertEquals(
			'住所を入力して下さい。',
			session('errors')->first('address')
		);
		$this->assertEquals(
			'場所予約を入力して下さい。',
			session('errors')->first('reservation')
		);
		$this->assertEquals(
			'参加費用を入力して下さい。',
			session('errors')->first('expense')
		);
		$this->assertEquals(
			'使用球を入力して下さい。',
			session('errors')->first('ball')
		);
		$this->assertEquals(
			'締切日時を入力して下さい。',
			session('errors')->first('deadline')
		);
		$this->assertEquals(
			'募集人数を入力して下さい。',
			session('errors')->first('people')
		);

		// 192文字の文字列を作成
		$badRemarksEdited = str_repeat('123', '64');

		// 再度投稿編集
		$response = $this->put("/posts/{$postId}", [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => $badRemarksEdited,
		]);

		// 上記投稿編集時のremarksカラムにおいて191文字を超えたことによりセッションにエラーデータが存在していることを確認
		$response->assertSessionHasErrors('remarks');

		// 正しいエラーメッセージが存在していることを確認
		$this->assertEquals(
			'備考は191文字以内として下さい。',
			session('errors')->first('remarks')
		);

		// 上記投稿がデータベースに保存されていないことを確認
		$this->assertDatabaseMissing('posts', [
			'remarks' => $badRemarksEdited,
		]);
	}

	// 投稿の編集に成功するテスト
	public function testPostEdit()
	{
		// ユーザを作成
		$user = factory(User::class)->create();

		// $userでログインして投稿作成
		$response = $this->actingAs($user)->post(route('posts.store', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarksEdit',
		]));

		// データベースに上記投稿が保存されていることを確認
		$this->assertDatabaseHas('posts', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarksEdit',
		]);

		// 上記投稿を選択して変数にidを代入
		$posts = new Post;
		$post = $posts->where('remarks', 'testRemarksEdit')->first();
		$postId = $post->id;

		// 上記投稿を編集する('remarks'を編集)
		$response = $this->put("/posts/{$postId}", [
			'title' => 'testTitleEdited',
			'date_time' => date('Y') . '-' . '02' . '-' . '03' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '03' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlaceEdited',
			'address' => 'testAddressEdited',
			'reservation' => '予約済み',
			'expense' => 'testExpenseEdited',
			'ball' => '硬式',
			'deadline' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '2',
			'remarks' => 'testRemarksEdited',
		]);

		// 編集後の投稿がデータベースに保存されていることを確認
		$this->assertDatabaseHas('posts', [
			'title' => 'testTitleEdited',
			'date_time' => date('Y') . '-' . '02' . '-' . '03' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '03' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlaceEdited',
			'address' => 'testAddressEdited',
			'reservation' => '予約済み',
			'expense' => 'testExpenseEdited',
			'ball' => '硬式',
			'deadline' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '2',
			'remarks' => 'testRemarksEdited',
		]);

		// 編集前の投稿がデータベースに存在しないことを確認
		$this->assertDatabaseMissing('posts', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarksEdit',
		]);
	}

	// アカウント削除時に該当アカウントによる投稿が削除されるテスト
	public function testPostDeleteAccount()
	{
		// ユーザを作成
		$user = factory(User::class)->create([
			'password' => bcrypt('testPostDeleteAccount'),
		]);

		// $userでログインして投稿作成
		$response = $this->actingAs($user)->post(route('posts.store', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarksPostDeleteAccount',
		]));

		// データベースに上記投稿が保存されていることを確認
		$this->assertDatabaseHas('posts', [
			'title' => 'testTitle',
			'date_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '00' . ':' . '00',
			'end_time' => date('Y') . '-' . '02' . '-' . '02' . ' ' . '00' . ':' . '30' . ':' . '00',
			'place' => 'testPlace',
			'address' => 'testAddress',
			'reservation' => '不要',
			'expense' => 'testExpense',
			'ball' => '軟式',
			'deadline' => date('Y') . '-' . '02' . '-' . '01' . ' ' . '00' . ':' . '00' . ':' . '00',
			'people' => '1',
			'remarks' => 'testRemarksPostDeleteAccount',
		]);

		// 上記投稿を選択して変数にidを代入
		$posts = new Post;
		$post = $posts->where('remarks', 'testRemarksPostDeleteAccount')->first();
		$userId = $post->user->id;

		// アカウントを削除
		$this->delete("/users/{$userId}", [
			'password' => 'testPostDeleteAccount',
		]);

		// 上記投稿がデータベースに存在しないことを確認
		$this->assertDatabaseMissing('posts', [
			'remarks' => 'testRemarksPostDeleteAccount',
		]);
	}
}
