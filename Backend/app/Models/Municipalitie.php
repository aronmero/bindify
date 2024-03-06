<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipalitie extends Model
{
    use HasFactory;

    protected $table = 'municipalities';

    protected $fillable = [
        "name",
    ];

    public function users(){

        return $this->hasMany(User::class, 'municipality_id');

    }

}