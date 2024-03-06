<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    use HasFactory;

    protected $table = 'hashtags';

    protected $fillable = [
        "name",
    ];

    public function commerces(){

        return $this->belongsToMany(Commerce::class, 'commerces_hashtags', 'hashtag_id', 'commerce_id');

    }

    public function posts(){

        return $this->belongsToMany(Post::class, 'posts_hashtags', 'hashtag_id', 'commerce_id');

    }

}
