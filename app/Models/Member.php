<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $fillable = [
        'staff_no',
        'name',
        'bank_name',
        'account_number',
        'account_name',
        'next_of_kin_name',
        'next_of_kin_relationship',
        'next_of_kin_phone',
        'next_of_kin_email',
        'next_of_kin_address',
        'monthly_contribution',
        'signed_agreement',
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
     // users
    public function user()
    {
        return $this->belongsTo(User::class, 'staff_no', 'staff_no');
    }

    // protected $table = 'hr.staff';

    // define relationships here
    // every member is a staff but not every staff is a member
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_no');
    }
}
