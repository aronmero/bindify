<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification_token extends Model
{
    use HasFactory;

    protected $table = 'verification_tokens';

    protected $fillable = [
        "token",
    ];

}
