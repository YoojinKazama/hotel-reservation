<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// ADDED FOR UUID INCREMENT ERROR       - Always add it to new controller
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

// ADDED FOR CREATED AND UPDATED BY AUTOMATION
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ADDED FOR UUID INCREMENT ERROR
    public $incrementing = false;

    protected $keyType = 'string';

    public static function boot(){
        parent::boot();

        static::creating(function ($issue) {
            $issue->id = Str::uuid(36);
        });
    }
}
