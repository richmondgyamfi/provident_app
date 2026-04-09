<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningBalance extends Model
{
    //
    protected $fillable = [
        'member_id',
        'amount',
        'financial_year',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'financial_year' => 'integer',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    
}
