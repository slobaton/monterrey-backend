<?php

namespace App\Enums;

enum IncomeType: string
{
    case PAYMENT = 'payment';
    case DISCOUNT = 'discount';
    case OTHER = 'other';
    case EMPTY = 'empty';
}
