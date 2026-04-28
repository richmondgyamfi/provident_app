<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $connection = 'hr';

    protected $table = 'unit';

    public $timestamps = false;

    public function save(array $options = []): void
    {
        // Throw an error if anything tries to save to this database
        throw new \Exception('The HR database is read-only.');
    }

    // specify all relationships with the hr database here
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class, 'unit_id');
    }

    // The relationship to the parent unit
    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    // Optional: The relationship to child units
    public function children()
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }

    // get the head of the unit
    public function head()
    {
        return $this->hasOne(Unit::class, 'unit_head');
    }
}
