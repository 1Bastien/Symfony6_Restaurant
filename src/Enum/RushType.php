<?php

namespace App\Enum;

use DateTimeImmutable;

enum RushType
{
    private const LUNCH_HOURS = [12, 13, 14];
    private const DINNER_HOURS = [18, 19, 20];

    case LUNCH;
    case DINNER;

    private static function any(mixed $needles, array $values): mixed
    {
        return in_array($needles, $values) ? $needles : null;
    }

    public function getStart(): int
    {
        return match ($this) {
            self::LUNCH => min(self::LUNCH_HOURS),
            self::DINNER => min(self::DINNER_HOURS),
        };
    }

    public function getEnd(): int
    {
        return match ($this) {
            self::LUNCH => max(self::LUNCH_HOURS),
            self::DINNER => max(self::DINNER_HOURS),
        };
    }

    /**
     * @throws \Exception
     */
    public static function fromHour(int $hour): RushType
    {
        return match ($hour) {
            self::any($hour, self::LUNCH_HOURS) => self::LUNCH,
            self::any($hour, self::DINNER_HOURS) => self::DINNER,
            default => throw new \Exception('Unexpected match value'),
        };
    }

    public static function fromDateTime(DateTimeImmutable $dateTime)
    {
        return self::fromHour($dateTime->format('G'));
    }
}
