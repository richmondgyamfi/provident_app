<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    //
protected $fillable = [
        'staff_no',
        'member_id',
        'uploaded_by',
        'payroll_month',
        'payroll_year',
        'contribution_amount',
        'employee_amount',
        'employer_amount',
        'basic_salary',
        'contribution_type',
        'payment_reference',
        'notes',
        'source',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'name');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('status', '!=', 'deleted');
    }

public function scopeRecent($query)
    {
        return $query->notDeleted()->latest()->limit(10);
    }

    public static function getMonthName($month)
    {
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March',
            4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September',
            10 => 'October', 11 => 'November', 12 => 'December',
        ];
        return $months[$month] ?? 'Unknown';
    }
}
