<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Coments extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function videos()
    {
        return $this->belongsTo(Videos::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sub_coments()
    {
        return $this->hasMany(Sub_coments::class);
    }
    public function like_comment()
    {
        return $this->hasMany(Like_comment::class);
    }

}
