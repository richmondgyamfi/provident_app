<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $connection = 'hr';

    protected $table = 'staff';

    public $timestamps = false;

    public function save(array $options = []): void
    {
        // Throw an error if anything tries to save to this database
        throw new \Exception('The HR database is read-only.');
    }

    // specify all relationships with the hr database here
    // every staff belongs to a unit but every unit does not have a staff
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    // specify the relationship to the job table
    // every staff has a job but every job does not have a staff
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    // a staff can have many promotions but a promotion belongs to one staff
    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'staff_no', 'staff_no');
    }
}
