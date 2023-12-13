<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $table = 'payment-table';

    protected $fillable = [
     'status', 'raw_response',
     'order_id', 'payment_type',
    ];
}
