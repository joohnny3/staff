<?php

namespace App\Enums;

use InvalidArgumentException;

enum NotifyServiceType: int
{
    case Gmail = 1;
    case Line = 2;
    case Jandi = 3;
    case Slack = 4;

    public static function service(string $service): self
    {
        return match (strtolower($service)) {
            'gmail' => self::Gmail,
            'line' => self::Line,
            'jandi' => self::Jandi,
            'slack' => self::Slack,
            default => throw new InvalidArgumentException("無效的通知服務: $service"),
        };
    }
}
