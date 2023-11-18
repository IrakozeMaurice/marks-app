<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function registrations()
    {
        return $this->hasMany(RegistrationForm::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
