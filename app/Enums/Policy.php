<?php

namespace App\Enums;

enum Policy: string
{
    case MANAGE_PRODUCTS = 'manage-products';
    case MANAGE_TAGS = 'manage-tags';
    case MANAGE_LOTS = 'manage-lots';
}
