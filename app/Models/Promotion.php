<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $connection = 'hr';

    protected $table = 'promotion';

    public $timestamps = false;

    public function save(array $options = []): void
    {
        // Throw an error if anything tries to save to this database
        throw new \Exception('The HR database is read-only.');
    }

    // specify all relationships with the hr database here
    // every promotion belongs to a staff but every staff can have many promotions
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_no');
    }
}
