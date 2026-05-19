<?php

declare(strict_types=1);

namespace App\Enums;

enum CharacterStatusEnum: string
{
    case Alive = 'Alive';
    case Dead = 'Dead';
    case Unknown = 'unknown';

    public static function fromValue(string $value): self
    {
        return self::tryFrom($value) ?? self::Unknown;
    }
}
