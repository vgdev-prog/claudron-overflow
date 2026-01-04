<?php

declare(strict_types=1);

namespace App\Enum;

enum AnswerStatus: string
{
    case APPROVED = 'APPROVED';
    case PENDING = 'PENDING';
    case REJECTED = 'REJECTED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
