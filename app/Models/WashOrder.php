<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WashOrder extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'client_id',
        'wash_type_id',
        'date',
        'total_quantity',
        'total_price',
        'deliver_quantity',
        'deliver_date',
        'observations'
    ];

    public function washType(): hasOne
    {
        return $this->hasOne(WashType::class);
    }

    public function client(): hasOne
    {
        return $this->hasOne(Client::class);
    }
}
