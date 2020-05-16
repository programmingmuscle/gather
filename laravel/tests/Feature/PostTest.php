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
    
    public function testPostError()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->post(route('posts.store', [
            'title' => '',
            'year' => '',
            'month' => '',
            'day' => '',
            'from_hour' => '',
            'from_minute' => '',
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
        
        $response->assertSessionHasErrors(['title', 'year', 'month', 'day', 'from_hour', 'from_minute', 'to_hour', 'to_minute', 'place', 'address', 'reservation', 'expense', 'ball', 'deadlineYear', 'deadlineMonth', 'deadlineDay', 'deadlineHour','deadlineMinute', 'people']);
        
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

    public function testPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->post(route('posts.store', [
            'title' => 'test',
            'year' => date('Y'),
            'month' => '1',
            'day' => '1',
            'from_hour' => '0',
            'from_minute' => '00',
            'to_hour' => '0',
            'to_minute' => '00',
            'place' => 'test',
            'address' => 'test',
            'reservation' => '不要',
            'expense' => 'test',
            'ball' => '軟式',
            'deadlineYear' => date('Y'),
            'deadlineMonth' => '1',
            'deadlineDay' => '1',
            'deadlineHour' => '0',
            'deadlineMinute' => '00',
            'people' => '1人',
        ]));

        $response->assertRedirect(route('users.show', ['id' => Auth::id()]));
        $response = $this->get(route('posts.index'));
        $response->assertSee('軟式');

        $this->assertDatabaseHas('posts', [
            'title' => 'test',
            'date_time' => date('Y') . '/' . '1' . '/' . '1' . ' ' . '0' . ':' . '00' . '~' . '0' . ':' . '00',
            'place' => 'test',
            'address' => 'test',
            'reservation' => '不要',
            'expense' => 'test',
            'ball' => '軟式',
            'deadline' => date('Y') . '/' . '1' . '/' . '1' . ' ' . '0' . ':' . '00',
            'people' => '1人',
        ]);
    }
}
