<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'purchase_id',
        'amount',
        'fee',
        'total',
        'status',
        'bank_account'
    ];

    /**
     * Get the purchase associated with the cashout.
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
