<?php

declare(strict_types=1);

namespace App\Enums;

enum CharacterGenderEnum: string
{
    case Female = 'Female';
    case Male = 'Male';
    case Genderless = 'Genderless';
    case Unknown = 'unknown';

    public static function fromValue(string $value): self
    {
        return self::tryFrom($value) ?? self::Unknown;
    }
}
