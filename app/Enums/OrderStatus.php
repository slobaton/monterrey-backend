<?php

namespace App\Enums;

enum OrderStatus: string
{
    case CREATED = 'created';
    case APPROVED = 'approved';
    case DELIVERED = 'delivered';
}
