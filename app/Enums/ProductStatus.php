<?php

namespace App\Enums;

enum ProductStatus: string
{
    case CREATED = 'created';
    case PENDING = 'pending lot';
    case BOUGHT = 'bought';
}
