<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'municipality_id',
        'avatar',
        'banner',
        'username',
        'nombre'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function notifications(){

        return $this->hasMany(Notification::class);

    }

    public function follows(){

        return $this->belongsToMany(User::class, 'followers', 'follows_id', 'follower_id');

    }

    public function follower(){

        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'follows_id');

    }

    public function posts(){

        return $this->belongsToMany(Post::class, 'users-posts', 'post_id', 'user_id');

    }

}
