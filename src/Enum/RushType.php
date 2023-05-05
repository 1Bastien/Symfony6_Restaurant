<?php

namespace App\Enum;

use DateTimeImmutable;

enum RushType
{
    private const MIDI_HOURS = [12, 13, 14];
    private const SOIR_HOURS = [18, 19, 20];

    case MIDI;
    case SOIR;

    private static function any(mixed $needles, array $values): mixed
    {
        return in_array($needles, $values) ? $needles : null;
    }

    public function getStart(): int
    {
        return match ($this) {
            self::MIDI => min(self::MIDI_HOURS),
            self::SOIR => min(self::SOIR_HOURS),
        };
    }

    public function getEnd(): int
    {
        return match ($this) {
            self::MIDI => max(self::MIDI_HOURS),
            self::SOIR => max(self::SOIR_HOURS),
        };
    }

    public static function fromString(string $rushType): RushType
    {
        return match ($rushType) {
            'midi' => self::MIDI,
            'soir' => self::SOIR,
        };
    }

    /**
     * @throws \Exception
     */
    public static function fromHour(int $hour): RushType
    {
        return match ($hour) {
            self::any($hour, self::MIDI_HOURS) => self::MIDI,
            self::any($hour, self::SOIR_HOURS) => self::SOIR,
            default => throw new \Exception('Unexpected match value'),
        };
    }

    public static function fromDateTime(DateTimeImmutable $dateTime)
    {
        return self::fromHour($dateTime->format('G'));
    }
}
