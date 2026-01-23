<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionRate extends Model
{
    use HasFactory;

    protected $table = 'commission_rates';
    
    protected $fillable = [
        'category',
        'amount',
    ];
}