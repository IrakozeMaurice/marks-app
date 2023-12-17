<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected $casts = [
        'semester_start_date' => 'date',
        'semester_end_date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)
            ->withTimestamps()
            ->withPivot(['group']);
    }
}
