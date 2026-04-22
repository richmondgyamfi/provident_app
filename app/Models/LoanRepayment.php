<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class LoanRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount',
        'payment_date',
        'installment_number',
        'payment_method',
        'reference',
        'notes',
        'loan_repayment_upload_id',
        'recorded_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'installment_number' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->recorded_by = Auth::id();
            }
        });
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    public function member(): BelongsTo
    {
        return $this->loan->member();
    }

    public function upload()
    {
        return $this->belongsTo(LoanRepaymentUpload::class, 'loan_repayment_upload_id');
    }
}
