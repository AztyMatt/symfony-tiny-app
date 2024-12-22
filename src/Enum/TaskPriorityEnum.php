<?php

declare(strict_types=1);

namespace App\Enum;

enum TaskPriorityEnum: string
{
    case NEUTRAL = 'Neutral';
    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';
}