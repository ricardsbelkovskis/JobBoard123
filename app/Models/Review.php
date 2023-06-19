<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Review extends Model
{
    protected $fillable = [
        'user_id', 
        'hire_id', 
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hire()
    {
        return $this->belongsTo(Hire::class, 'hire_id');
    }
    
}