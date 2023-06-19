<?php

namespace App\Models;
use App\Models\Photo;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Hire extends Model
{
    protected $fillable = ['title', 'description', 'price', 'time_to_finish'];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
