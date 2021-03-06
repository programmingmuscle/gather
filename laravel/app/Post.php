<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = [
		'user_id', 'title', 'date_time', 'end_time', 'place', 'address', 'reservation', 'expense', 'ball', 'deadline', 'people', 'remarks'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function messages()
	{
		return $this->hasMany(Message::class);
	}

	public function participate_users()
	{
		return $this->belongsToMany(User::class, 'participations', 'post_id', 'user_id')->withTimestamps();
	}
}
