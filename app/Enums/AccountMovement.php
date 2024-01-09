<?php

namespace App\Enums;

enum AccountMovement: string
{
    case CHARGE = 'charge';
    case PAYMENT = 'payment';
}
