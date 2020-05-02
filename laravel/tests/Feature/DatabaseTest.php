<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class DatabaseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    
     // テスト開始時に未済のマイグレーションを実行 終了時にデータを削除する
    use RefreshDatabase;

    // データベースへの登録をテスト
    public function testDatabase()
    {
        // ユーザ作成
        factory(User::class)->create([
            'name' => 'AAA',
            'email' => 'BBB@CCC.COM',
            'password' => 'ABCABC',
            'residence' => 'Tokyo',
            'gender' => '男性',
            'age' => '10代',
            'experience' => '5年未満',
            'position' => '投手',
            'introduction' => 'よろしくお願いします。',
        ]);
        
        // その他ユーザを10件作成
        factory(User::class, 10)->create();

        // はじめに作成したユーザ情報が登録されているか確認
        $this->assertDatabaseHas('users', [
            'name' => 'AAA',
            'email' => 'BBB@CCC.COM',
            'password' => 'ABCABC',
            'residence' => 'Tokyo',
            'gender' => '男性',
            'age' => '10代',
            'experience' => '5年未満',
            'position' => '投手',
            'introduction' => 'よろしくお願いします。',
        ]);
    }
}
