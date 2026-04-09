<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'loan_type_id',
        'amount',
        'interest_rate',
        'term_months',
        'monthly_payment',
        'total_repayable',
        'outstanding_balance',
        'status',
        'purpose',
        'application_ref',
        'approved_by',
        'disbursed_at',
        'documents_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'monthly_payment' => 'decimal:2',
        'total_repayable' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'disbursed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->member_id = Auth::id(); // or map from user staff_no
            }
            if (!$model->application_ref) {
                $model->application_ref = 'LN-' . date('Y') . '-' . str_pad($model->id ?? rand(1,99999), 5, '0', STR_PAD_LEFT);
            }
            $model->status = 'pending';
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'approved' => 'green',
            'pending' => 'yellow',
            'rejected' => 'red',
            'disbursed' => 'blue',
            default => 'gray',
        };
    }
}
