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
            'year' => '',
            'month' => '',
            'day' => '',
            'from_hour' => '',
            'from_minute' => '',
            'to_year' => '',
            'to_month' => '',
            'to_day' => '',
            'to_hour' => '',
            'to_minute' => '',
            'place' => '',
            'address' => '',
            'reservation' => '',
            'expense' => '',
            'ball' => '',
            'deadlineYear' => '',
            'deadlineMonth' => '',
            'deadlineDay' => '',
            'deadlineHour' => '',
            'deadlineMinute' => '',
            'people' => '',
        ]));
        
        // 上記投稿作成時の入力必須項目において空欄となっていたものについてセッションにエラーデータが存在していることを確認
        $response->assertSessionHasErrors(['title', 'year', 'month', 'day', 'from_hour', 'from_minute', 'to_year', 'to_month', 'to_day', 'to_hour', 'to_minute', 'place', 'address', 'reservation', 'expense', 'ball', 'deadlineYear', 'deadlineMonth', 'deadlineDay', 'deadlineHour','deadlineMinute', 'people']);
        
        // 各項目のエラーに対して正しいエラーメッセージが存在していることを確認
        $this->assertEquals('タイトルを入力して下さい。',
            session('errors')->first('title'));
        $this->assertEquals('開催年を入力して下さい。',
            session('errors')->first('year'));
        $this->assertEquals('開催月を入力して下さい。',
            session('errors')->first('month'));
        $this->assertEquals('開催日を入力して下さい。',
            session('errors')->first('day'));
        $this->assertEquals('開始時間を入力して下さい。',
            session('errors')->first('from_hour'));
        $this->assertEquals('開始時間（分）を入力して下さい。',
            session('errors')->first('from_minute'));
        $this->assertEquals('終了年を入力して下さい。',
            session('errors')->first('to_year'));
        $this->assertEquals('終了月を入力して下さい。',
            session('errors')->first('to_month'));
        $this->assertEquals('終了日を入力して下さい。',
            session('errors')->first('to_day'));
        $this->assertEquals('終了時間を入力して下さい。',
            session('errors')->first('to_hour'));
        $this->assertEquals('終了時間（分）を入力して下さい。',
            session('errors')->first('to_minute'));
        $this->assertEquals('場所を入力して下さい。',
            session('errors')->first('place'));
        $this->assertEquals('住所を入力して下さい。',
            session('errors')->first('address'));
        $this->assertEquals('場所予約を入力して下さい。',
            session('errors')->first('reservation'));
        $this->assertEquals('参加費用を入力して下さい。',
            session('errors')->first('expense'));
        $this->assertEquals('使用球を入力して下さい。',
            session('errors')->first('ball'));
        $this->assertEquals('締切年を入力して下さい。',
            session('errors')->first('deadlineYear'));
        $this->assertEquals('締切月を入力して下さい。',
            session('errors')->first('deadlineMonth'));
        $this->assertEquals('締切日を入力して下さい。',
            session('errors')->first('deadlineDay'));
        $this->assertEquals('締切時間を入力して下さい。',
            session('errors')->first('deadlineHour'));
        $this->assertEquals('締切時間（分）を入力して下さい。',
            session('errors')->first('deadlineMinute'));
        $this->assertEquals('募集人数を入力して下さい。',
            session('errors')->first('people'));
    }

    // 投稿作成に成功するテスト
    public function testPost()
    {
        // ユーザを作成
        $user = factory(User::class)->create();

        // $userでログインして投稿作成
        $response = $this->actingAs($user)->post(route('posts.store', [
            'title' => 'testTitle',
            'year' => date('Y'),
            'month' => '2',
            'day' => '1',
            'from_hour' => '0',
            'from_minute' => '00',
            'to_year' => date('Y'),
            'to_month' => '2',
            'to_day' => '1',
            'to_hour' => '1',
            'to_minute' => '00',
            'place' => 'testPlace',
            'address' => 'testAddress',
            'reservation' => '不要',
            'expense' => 'testExpense',
            'ball' => '軟式',
            'deadlineYear' => date('Y'),
            'deadlineMonth' => '1',
            'deadlineDay' => '1',
            'deadlineHour' => '0',
            'deadlineMinute' => '00',
            'people' => '1人',
            'remarks' => 'testRemarks',
        ]));

        // データベースに上記投稿が保存されていることを確認
        $this->assertDatabaseHas('posts', [
            'title' => 'testTitle',
            'date_time' => date('Y') . '/' . '2' . '/' . '1' . ' ' . '0' . ':' . '00',
            'end_time' => date('Y') . '/' . '2' . '/' . '1' . ' ' . '1' . ':' . '00',
            'place' => 'testPlace',
            'address' => 'testAddress',
            'reservation' => '不要',
            'expense' => 'testExpense',
            'ball' => '軟式',
            'deadline' => date('Y') . '/' . '1' . '/' . '1' . ' ' . '0' . ':' . '00',
            'people' => '1人',
            'remarks' => 'testRemarks',
        ]);

        // 上記投稿を選択して変数に代入
        $post = Post::first();

        // 投稿作成後に投稿詳細画面にリダイレクトされていることを確認
        $response->assertRedirect(route('posts.show', ['id' => $post->id]));

        // 投稿詳細画面に上記投稿が表示されることを確認
        $response = $this->get(route('posts.show', ['id' => $post->id]));
        $response->assertSee('投稿詳細')
                 ->assertSee('testTitle')
                 ->assertSee(date('Y') . '/' . '2' . '/' . '1' . ' ' . '0' . ':' . '00')
                 ->assertSee(date('Y') . '/' . '2' . '/' . '1' . ' ' . '1' . ':' . '00')
                 ->assertSee('testPlace')
                 ->assertSee('testAddress')
                 ->assertSee('不要')
                 ->assertSee('testExpense')
                 ->assertSee('軟式')
                 ->assertSee(date('Y') . '/' . '1' . '/' . '1' . ' ' . '0' . ':' . '00')
                 ->assertSee('1人')
                 ->assertSee('testRemarks');

        // 投稿一覧画面に遷移して上記投稿が表示されることを確認
        $response = $this->get(route('posts.index'));
        $response->assertSee('投稿一覧')
                 ->assertSee('testTitle')
                 ->assertSee(date('Y') . '/' . '2' . '/' . '1' . ' ' . '0' . ':' . '00')
                 ->assertSee(date('Y') . '/' . '2' . '/' . '1' . ' ' . '1' . ':' . '00')
                 ->assertSee('testPlace')
                 ->assertSee('testAddress')
                 ->assertSee('不要')
                 ->assertSee('testExpense')
                 ->assertSee('軟式')
                 ->assertSee(date('Y') . '/' . '1' . '/' . '1' . ' ' . '0' . ':' . '00')
                 ->assertSee('1人')
                 ->assertSee('testRemarks');
    }
}
