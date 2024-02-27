<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintHistory extends Model
{
    protected $fillable = ['user_id', 'wash_order_id', 'created_at'];

    protected $table = 'print_history';
}
