<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    use HasFactory;

    protected $table = 'commerces';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        "user_id",
        "address",
        'description',
        'verification_token_id',
        'verificated',
        'opening_hour',
        'closing_hour',
        'active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function hashtags(){

        return $this->belongsToMany(Hashtag::class, 'commerces-hashtags', 'hashtag_id', 'commerce_id');

    }

    public function token(){

        return $this->belongsTo(Verification_token::class, 'verification_token_id');

    }

}
