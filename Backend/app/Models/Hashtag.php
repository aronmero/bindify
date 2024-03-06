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

        return $this->belongsToMany(Commerce::class, 'commerce_hashtags', 'hashtag_id', 'commerce_id');

    }

}
