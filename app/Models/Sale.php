<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id',       
    'vehicle_model',
    'category',
    'buyer_name',
    'sale_price',
    'commission',
    'notes',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}