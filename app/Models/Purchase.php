<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'hire_id',
        'stripe_session_id',
    ];

    /**
     * Get the user that owns the purchase.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the hire that was purchased.
     */
    public function hire()
    {
        return $this->belongsTo(Hire::class);
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'hire_id');
    }
}