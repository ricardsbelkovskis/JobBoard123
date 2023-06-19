<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class, 'diy_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite_diy_user')->withTimestamps();
    }
}
