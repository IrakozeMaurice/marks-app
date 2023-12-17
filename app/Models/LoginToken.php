<?php

namespace App\Models;

use App\Mail\LoginConfirmation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_user_id',
        'token'
    ];

    public function getRouteKeyName()
    {
        return 'token';
    }

    public static function generateFor(TeacherUser $user)
    {
        return static::create([
            'teacher_user_id' => $user->id,
            'token' => Str::random(50),
        ]);
    }

    public function send()
    {
        Mail::to($this->teacherUser->email)->send(new LoginConfirmation($this->token));
    }

    public function teacherUser()
    {
        return $this->belongsTo(TeacherUser::class);
    }
}
