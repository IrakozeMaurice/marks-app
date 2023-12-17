<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'claim_deadline' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function markExcels()
    {
        return $this->hasMany(MarkExcel::class);
    }

    public function claimDeadlineExpired()
    {
        return Carbon::now()->gt($this->claim_deadline);
    }
}
