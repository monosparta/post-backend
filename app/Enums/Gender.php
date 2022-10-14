<?php declare(strict_types=1);

namespace App\Enums;

enum Gender: int
{
    case female = 0;
    case male = 1;
    case other = 2;
}
