<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['path'];

    public function hire()
    {
        return $this->belongsTo(Hire::class);
    }
}
