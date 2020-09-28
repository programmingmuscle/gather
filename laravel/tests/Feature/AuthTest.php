<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @return void
	 */

	// テスト開始時に未済のマイグレーションを実行 終了時にデータを削除する
	use RefreshDatabase;

	// サインアップ実行 成功し画面遷移するまでの挙動をテスト
	public function testSignup() {
		// ログイン状態をチェック 未ログインであることを確認
		$this->assertFalse(Auth::check());

		// サインアップを実行
		$response = $this->post('signup', [
			'name' => 'test',
			'email' => 'aaa@bbb.com',
			'password' => 'testPassword',
			'password_confirmation' => 'testPassword',
		]);

		// ログイン状態をチェック ログイン状態であることを確認
		$this->assertTrue(Auth::check());

		// ログインユーザ自身の詳細画面へリダイレクトされることを確認
		$response->assertRedirect(route('users.show', ['id' => Auth::id()]));
	}

	// サインアップを実行 失敗し対応するエラーメッセージが表示されるまでの挙動をテスト
	public function testSignupError() {
		// 全て空欄でサインアップ実行
		$response = $this->post('signup', [
			'name' => '',
			'email' => '',
			'password' => '',
			'password_confirmation' => '',
		]);

		// ログイン状態をチェック 未ログイン状態であることを確認
		$this->assertFalse(Auth::check());

		// エラーデータがストックされていることを確認
		$response->assertSessionHasErrors(['name', 'email', 'password']);

		// 意図したエラーメッセージが表示されているか確認
		$this->assertEquals('選手名を入力して下さい。',
			session('errors')->first('name'));
		$this->assertEquals('メールアドレスを入力して下さい。',
			session('errors')->first('email'));
		$this->assertEquals('パスワードを入力して下さい。',
			session('errors')->first('password'));

		// 成立していないメールアドレスでサインアップ実行
		$response = $this->post('signup', [
			'name' => 'test',
			'email' => 'aaabbb.com',
			'password' => 'test12',
			'password_confirmation' => 'test12',
		]);

		// ログイン状態をチェック 未ログイン状態であることを確認
		$this->assertFalse(Auth::check());

		// エラーデータがストックされていることを確認
		$response->assertSessionHasErrors(['email']);

		// 意図したエラーメッセージが表示されているか確認
		$this->assertEquals('メールアドレスに「@」を挿入して下さい。',
			session('errors')->first('email'));

		// パスワードが確認用と一致しない状態でサインアップ実行
		$response = $this->post('signup', [
			'name' => 'test',
			'email' => 'aaa@bbb.com',
			'password' => 'test12',
			'password_confirmation' => 'Test12',
		]);

		// ログイン状態をチェック 未ログイン状態であることを確認
		$this->assertFalse(Auth::check());

		// エラーデータがストックされていることを確認
		$response->assertSessionHasErrors(['password']);

		// 意図したエラーメッセージが表示されているか確認
		$this->assertEquals('確認用パスワードと一致していません。',
			session('errors')->first('password'));

		// ユーザ作成
		$user = factory(User::class)->create([
			'email' => 'aaa@bbb.com',
		]);

		// すでに使用されているメールアドレスにてサインアップ実行
		$response = $this->post('signup', [
			'name' => 'test',
			'email' => 'aaa@bbb.com',
			'password' => 'test12',
			'password_confirmation' => 'test12',
		]);

		// ログイン状態をチェック 未ログイン状態であることを確認
		$this->assertFalse(Auth::check());

		// エラーデータがストックされていることを確認
		$response->assertSessionHasErrors(['email']);

		// 意図したエラーメッセージが表示されているか確認
		$this->assertEquals('入力されたメールアドレスは既に使用されています。',
			session('errors')->first('email'));
	}

	// ログイン実行 成功し画面遷移するまでの挙動をテスト
	public function testLogin() {
		// ログインパスワードが'test12'のユーザ作成
		$user = factory(User::class)->create([
			'password' => bcrypt('test12')
		]);

		// ログイン状態をチェック 未ログインであることを確認
		$this->assertFalse(Auth::check());

		// メールアドレスとパスワードでログイン
		$response = $this->post('login', [
			'email' => $user->email,
			'password' => 'test12',
		]);

		// ログイン状態をチェック ログインに成功したことを確認
		$this->assertTrue(Auth::check());

		// ログインユーザ自身の詳細画面へリダイレクトされることを確認
		$response->assertRedirect(route('users.show', ['id' => Auth::id()]));
	}

	// ログイン実行 失敗し対応するエラーメッセージが表示されるまでの挙動をテスト
	public function testLoginError() {
		// ログインパスワードが'test12'のユーザ作成
		$user = factory(User::class)->create([
			'password' => bcrypt('test12')
		]);

		// ログイン状態をチェック 未ログインであることを確認
		$this->assertFalse(Auth::check());

		// 誤ったパスワードでログインを試みる
		$response = $this->post('login', [
			'email' => $user->email,
			'password' => 'Test12',
		]);

		//ログイン状態をチェック ログインに失敗したことを確認
		$this->assertFalse(Auth::check());

		// エラーデータがストックされていることを確認
		$response->assertSessionHasErrors(['email']);

		// 意図したエラーメッセージが表示されているか確認
		$this->assertEquals('メールアドレスかパスワードが間違っています。',
			session('errors')->first('email'));

		// メールアドレスとパスワードともに空欄でログインを試みる
		$response = $this->post('login', [
			'email' => '',
			'password' => '',
		]);

		// ログイン状態をチェック ログインに失敗したことを確認
		$this->assertFalse(Auth::check());

		// エラーデータがストックされていることを確認
		$response->assertSessionHasErrors(['email', 'password']);

		// 意図したエラーメッセージが表示されているか確認
		$this->assertEquals('メールアドレスを入力して下さい。',
			session('errors')->first('email'));
		$this->assertEquals('パスワードを入力して下さい。',
			session('errors')->first('password'));
	}

	// ログアウトを実行し画面が遷移するまでの挙動をテスト
	public function testLogout() {
		// ユーザを作成
		$user = factory(User::class)->create();

		// ログイン状態へ
		$this->actingAs($user);

		// ログイン状態であることを確認
		$this->assertTrue(Auth::check());

		// ログアウトを実行
		$response = $this->get('logout');

		// 未ログイン状態であることを確認
		$this->assertFalse(Auth::check());

		// トップページにリダイレクトされることを確認
		$response->assertRedirect('/');
	}
}