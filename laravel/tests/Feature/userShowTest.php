<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;

class userShowTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    // テスト開始時に未済のマイグレーションを実行 終了時にデータを削除する
    use RefreshDatabase;

    // ユーザ詳細のタイムラインタブに自身及びフォロー中ユーザの投稿が表示されているか確認するテスト
    public function testShow()
    {
        // フォロー対象とするユーザを作成
        $user = factory(User::class)->create();

        $post = factory(Post::class)->create([
            'title' => 'postTest',
        ]);

        // $userでログイン状態になり投稿作成
        $this->actingAs($user)->post(route('posts.store', [
            'title' => 'postTest1',
            'year' => date('Y'),
            'month' => '01',
            'day' => '01',
            'from_hour' => '00',
            'from_minute' => '00',
            'to_hour' => '00',
            'to_minute' => '00',
            'place' => 'test',
            'address' => 'test',
            'reservation' => '不要',
            'expense' => 'test',
            'ball' => '軟式',
            'deadlineYear' => date('Y'),
            'deadlineMonth' => '01',
            'deadlineDay' => '01',
            'deadlineHour' => '00',
            'deadlineMinute' => '00',
            'people' => '1人',
        ]));

        // ログアウトを実行
        $this->get('logout');

        // 未ログイン状態であることを確認
        $this->assertFalse(Auth::check());

        // サインアップする
        $this->post(route('signup.post', [
            'name' => 'test2',
            'email' => 'aaa2@bbb.com',
            'password' => 'testPassword2',
            'password_confirmation' => 'testPassword2',
        ]));

        // ログイン状態をチェック ログイン状態であることを確認
        $this->assertTrue(Auth::check());

        // 投稿を作成
        $this->post(route('posts.store', [
            'title' => 'postTest2',
            'year' => date('Y'),
            'month' => '01',
            'day' => '01',
            'from_hour' => '00',
            'from_minute' => '00',
            'to_hour' => '00',
            'to_minute' => '00',
            'place' => 'test',
            'address' => 'test',
            'reservation' => '不要',
            'expense' => 'test',
            'ball' => '軟式',
            'deadlineYear' => date('Y'),
            'deadlineMonth' => '01',
            'deadlineDay' => '01',
            'deadlineHour' => '00',
            'deadlineMinute' => '00',
            'people' => '1人',
        ]));

        // フォロー機能を実行 $userをフォローする
        $this->post(route('user.follow', ['id' => $user->id]));

        // ユーザ詳細のタイムラインタブに自身及びフォロー中ユーザの投稿が表示されていることを確認
        $response = $this->get(route('users.show', ['id' => Auth::id()]));
        $response->assertSee('postTest1');

        // ユーザ詳細の投稿タブに自身の投稿のみが表示されていることを確認
        $response = $this->get(route('users.posts', ['id' => Auth::id()]));
        $response->assertSee('postTest2');
        $response->assertDontSee('postTest1');

        // 参加機能を実行 $postに参加する
        $this->post(route('participations.participate', ['id' => $post->id]));

        // ユーザ詳細の参加タブに参加機能を実行した対象の投稿が表示されていることを確認
        $response = $this->get(route('users.participations', ['id' => Auth::id()]));
        $response->assertSee('postTest');

        // 気になる機能を実行 $postに気になるする
        $this->post(route('concerns.concern', ['id' => $post->id]));

        // ユーザ詳細の気になるタブに気になる機能を実行した対象の投稿が表示されていることを確認
        $response = $this->get(route('users.concerns', ['id' => Auth::id()]));
        $response->assertSee('postTest');
    }
}
