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

    // protected $table = 'hr.staff';

    // define relationships here
    // every member is a staff but not every staff is a member
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_no');
    }
}
