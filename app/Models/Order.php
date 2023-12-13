<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order-table';

    protected $fillable = [
     'food_id', 'user_id', 'amount',
     'status', 'transaction_code'
    ];
}
