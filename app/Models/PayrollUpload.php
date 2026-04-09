<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PayrollUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'file_path',
        'records_count',
        'status',
        'user_id',
        'notes',
    ];

    protected $casts = [
        'records_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'payroll_upload_id');
    }
}
