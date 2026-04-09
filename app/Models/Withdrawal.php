<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'amount',
        'reason',
        'request_date',
        'status',
        'notes',
        'approved_amount',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'request_date' => 'date',
        'processed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->member_id = Auth::user()->member_id ?? Auth::id();
            }
            $model->request_date = now();
            $model->status = 'pending';
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'approved' => 'green',
            'pending' => 'yellow',
            'rejected' => 'red',
            'paid' => 'blue',
            default => 'gray',
        };
    }
}
