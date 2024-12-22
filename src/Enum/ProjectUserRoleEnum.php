<?php

declare(strict_types=1);

namespace App\Enum;

enum ProjectUserRoleEnum: string
{
    case CREATOR = 'Creator';
    case MANAGER = 'Manager';
    case MEMBER = 'Member';
}