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
    public function promotion()
    {
        return $this->hasOne(Promotion::class, 'staff_no', 'staff_no')->latestOfMany();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'staff_no', 'staff_no');
    }

    /**
     * Get the department name, prioritizing the promotion unit
     * and falling back to the base staff unit.
     */
    public function getDepartmentAttribute()
    {
        return $this->promotion->unit->long_name ?? $this->unit->long_name ?? null;
    }

    /**
     * Get the job title, prioritizing the promotion title
     * and falling back to the base staff job title.
     */
    public function getJobTitleAttribute()
    {
        return $this->promotion->job->title ?? $this->job->title ?? null;
    }
}
