<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function favoriteDiys()
    {
        return $this->belongsToMany(Diy::class, 'favorite_diy_user')->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(Diy::class, 'favorite_diy_user', 'user_id', 'diy_id');
    }

    public function diys()
    {
        return $this->hasMany(Diy::class);
    }
    
    public function posts()
    {
        return $this->hasMany(Diy::class, 'user_id');
    }

    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getRoleAttribute()
    {
        $postCount = $this->posts()->count();
    
        if ($postCount >= 10) {
            return 'Content Creator';
        } elseif ($postCount >= 5) {
            return 'Member';
        } else {
            return 'New';
        }
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    
    public function hires()
    {
        return $this->hasMany(Hire::class);
    }

    public function hiredForWithPurchase()
    {
        return $this->hasManyThrough(
            Hire::class,
            Purchase::class,
            'user_id', // Foreign key on purchases table
            'id', // Foreign key on hires table
            'id', // Local key on users table
            'hire_id' // Local key on purchases table
        );
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'hire_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'user_id');
    }


}
