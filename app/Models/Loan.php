<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loan_type_id',
        'amount',
        'interest_rate',
        'term_months',
        'monthly_payment',
        'total_repayable',
        'outstanding_balance',
        'status',
        'purpose',
        'chk_read',
        'chk_accurate',
        'chk_deduction',
        'chk_default',
        'chk_signature',
        'fullname',
        'signed_date',
        'doc_id',
        'doc_payslip',
        'doc_letter',
        'doc_bank',
        'doc_purpose',
        'doc_other',
        'application_ref',
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
                $model->user_id = Auth::user()->id; // or map from user staff_no
            }
            if (! $model->application_ref) {
                $model->application_ref = 'LN-'.date('Y').'-'.str_pad($model->id ?? rand(1, 99999), 5, '0', STR_PAD_LEFT);
            }
            $model->status = 'pending';
            $model->outstanding_balance = $model->amount; // init
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return match ($this->status) {
            'approved' => 'green',
            'pending' => 'yellow',
            'rejected' => 'red',
            'disbursed' => 'blue',
            default => 'gray',
        };
    }

    public function applyRepayment($amount)
    {
        $this->increment('total_repayable', $amount);
        $newBalance = max(0, $this->outstanding_balance - $amount);
        $this->update(['outstanding_balance' => $newBalance]);
        if ($newBalance === 0) {
            $this->update(['status' => 'repaid']);
        }

        return $this->fresh();
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'repaid')
            ->where('status', '!=', 'rejected')
            ->where('outstanding_balance', '>', 0);
    }
}
