<?php

namespace App\Enums;

enum IncomeReceiptStatus: string
{
    case ACTIVE = 'active';
    case CANCELED = 'canceled';
}
