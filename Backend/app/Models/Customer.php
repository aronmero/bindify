<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        "user_id",
        "gender",
        'birth_date',
    ];

    public function reviews(){

        return $this->hasMany(Review::class);

    }

}
