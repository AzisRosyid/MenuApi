<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHeader extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'date',
        'payment_id',
        'card_number',
        'bank'
    ];
    use HasFactory;
}
