<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        "user_id",
        "commerce_id",
        'comment',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commerce()
    {
        return $this->belongsTo(Commerce::class);
    }

}
