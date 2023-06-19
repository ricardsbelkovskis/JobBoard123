<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function diy()
    {
        return $this->belongsTo(Diy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
