<?php

declare(strict_types=1);

namespace App\Enum;

enum ProjectStatusEnum: string
{
    case PLANNED = 'Planned';
    case IN_PROGRESS = 'In progress';
    case COMPLETED = 'Completed';
    case ARCHIVED = 'Archived';
}