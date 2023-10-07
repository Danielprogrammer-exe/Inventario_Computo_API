<?php

namespace App\Enums;

enum StateEnum: int
{
    case DELETED = 0;
    case ENABLED = 1;
    case DISABLED = 2;
}
