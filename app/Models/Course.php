<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function registrations()
    {
        return $this->belongsToMany(Registration::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
