<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'phone_no',
        'staff_no',
        'date_of_birth',
        'company',
        'job_title',
        'account_type',
        'password',
        // 'api_key',
        'role',
        'is_active',
        'last_active_at',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin') || $this->hasRole('super_admin');
    }

    public function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : 0,
        );
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // specify all relationships with the hr database here

    // user has a one to one relationship with staff
    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_no', 'staff_no');
    }

    // every user has a job but every job does not have a user
    public function job()
    {
        return $this->hasOne(Job::class, 'title', 'job_title');
    }
}
