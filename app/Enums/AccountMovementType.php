<?php

namespace App\Enums;

enum AccountMovementType: string
{
    case CHARGE = 'charge';
    case PAYMENT = 'payment';
}
