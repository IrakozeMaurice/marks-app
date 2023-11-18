<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherUser extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
