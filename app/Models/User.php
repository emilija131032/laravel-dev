<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'avatar',
        'avatarBig'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function sentUserRegisterEmail($email)
    {
        // Send email
        Mail::to($email)->send(new \App\Mail\inviteEmail($email));

    }

    public static function sendWelcomeMail($user)
    {
        // Send email delayed 5min = 300s
        Mail::later(300, 'email.welcome', function ($m, $user) {
            $m->to($user->email)->subject('Welcome');
        });

    }
}
