<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'father_id',
        'active'
    ];

    public function replies(){

        return $this->hasMany(Comment::class, 'father_id');

    }

    public function user(){

        return $this->belongsTo(User::class, 'user_id');
    }

    public function post(){

        return $this->belongsTo(Post::class, 'post_id');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'element');
    }
}
