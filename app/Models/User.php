<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    public function videos()
    {
        return $this->hasMany(Videos::class);
    }
    public function historiques()
    {
        return $this->hasMany(Historiques::class);
    }
    public function subscribe()
    {
        return $this->hasMany(Subscribe::class);
    }
    public function chanels()
    {
        return $this->hasMany(Chanels::class);
    }
    public function play_list()
    {
        return $this->hasMany(Play_list::class);
    }
    public function coments()
    {
        return $this->hasMany(Coments::class);
    }
    public function sub_coments()
    {
        return $this->hasMany(Sub_coments::class);
    }
    public function like_video()
    {
        return $this->hasMany(Like_video::class);
    }
    public function like_comment()
    {
        return $this->hasMany(Like_comment::class);
    }
    public function like_comment_Sub()
    {
        return $this->hasMany(Like_comment_Sub::class);
    }
    public function support()
    {
        return $this->hasMany(Support::class);
    }
}
