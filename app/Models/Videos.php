<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Videos extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function historiques()
    {
        return $this->hasMany(Historiques::class);
    }
    public function views()
    {
        return $this->hasMany(Views::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function chanels()
    {
        return $this->belongsTo(Chanels::class);
    }
    public function coments()
    {
        return $this->hasMany(Coments::class);
    }
    public function like_video()
    {
        return $this->hasMany(Like_video::class);
    }
}
