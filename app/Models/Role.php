<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class role extends Model
{
    use HasFactory;

    /**     * The attributes that are mass assignable.
     *      * @var array<int, string>
     *      */
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the users associated with the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users');
    }

    /**
     * Scope a query to only include active roles.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
