<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_type extends Model
{
    use HasFactory;

    protected $table = 'post_types';

    protected $fillable = [
        'name',
    ];

    public function posts(){

        return $this->hasMany(Post::class);

    }

}
