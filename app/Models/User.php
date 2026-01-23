<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    
    protected $fillable = [
        'citizen_id',
        'name',
        'username', 
        'password',
        'role',     
        'is_on_duty',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_on_duty' => 'boolean',
    ];

   public function dutySessions()
    {
        return $this->hasMany(DutySession::class);
    }
    
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}