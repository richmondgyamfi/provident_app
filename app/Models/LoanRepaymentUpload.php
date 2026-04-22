<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LoanRepaymentUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'file_path',
        'records_count',
        'status',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'records_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class, 'loan_repayment_upload_id');
    }
}
