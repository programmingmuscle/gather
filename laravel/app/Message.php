<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $fillable = ['content', 'user_id', 'post_id', 'user_name', 'user_profile_image'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function post()
	{
		return $this->belongsTo(Post::class);
	}
}
