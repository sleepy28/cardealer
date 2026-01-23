<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySetting extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'role', 
        'base_salary', 
        'overtime_rate', 
        'threshold_hours'
    ];
}