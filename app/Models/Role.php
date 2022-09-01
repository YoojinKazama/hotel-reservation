<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ADDED FOR UUID INCREMENT ERROR       - Always add it to new controller
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

// ADDED FOR CREATED AND UPDATED BY AUTOMATION
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "title"
    ];

    protected $dates =[
        "deleted_at"
    ];

    // [Default relationship]       - Default
    public function created_by_user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    // ADDED FOR UUID INCREMENT ERROR
    public $incrementing = false;

    protected $keyType = 'string';

    public static function boot(){
        parent::boot();

        static::creating(function ($issue) {
            $issue->id = Str::uuid(36);
        });
    }
    //
    
    
}
