<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','residence','gender','age','experience','position','introduction', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function followings() 
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followers() 
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    public function is_following($id) 
    {
        return $this->followings()->where('follow_id', $id)->exists();
    }

    public function follow($id) 
    {
        $exist = $this->is_following($id);
        $its_me = $this->id == $id;

        if (!$exist && !$its_me) {
            $this->followings()->attach($id);
        }
    }

    public function unfollow($id)
    {
        $exist = $this->is_following($id);
        $its_me = $this->id == $id;

        if ($exist && !$its_me) {
            $this->followings()->detach($id);
        }
    }
}
