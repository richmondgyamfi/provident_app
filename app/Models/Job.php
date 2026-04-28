<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $connection = 'hr';

    protected $table = 'job';

    public $timestamps = false;

    public function save(array $options = []): void
    {
        // Throw an error if anything tries to save to this database
        throw new \Exception('The HR database is read-only.');
    }

    // specify all relationships with the hr database here
    // every job has many staff but every staff does not have a job
    public function staff()
    {
        return $this->hasMany(Staff::class, 'job_id');
    }

    // every job has many users and every user has a job
    public function users()
    {
        return $this->hasMany(User::class, 'job_title', 'title');
    }
}
