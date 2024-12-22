<?php

declare(strict_types=1);

namespace App\Enum;

enum TaskStatusEnum: string
{
    case TO_DO = 'To Do';
    case IN_PROGRESS = 'In Progress';
    case DONE = 'Done';
}