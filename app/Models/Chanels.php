<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Chanels extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'description', 'logo_path','img_path'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function links()
    {
        return $this->hasMany(Links::class);
    }
    public function videos()
    {
        return $this->hasMany(Videos::class);
    }
    public function play_list()
    {
        return $this->hasMany(Play_list::class);
    }
}
