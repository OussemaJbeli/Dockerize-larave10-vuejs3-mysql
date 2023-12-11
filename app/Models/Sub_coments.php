<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Sub_coments extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function coments()
    {
        return $this->belongsTo(Coments::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function like_comment_Sub()
    {
        return $this->hasMany(Like_comment_Sub::class);
    }

}
