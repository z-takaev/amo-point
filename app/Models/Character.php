<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CharacterGenderEnum;
use App\Enums\CharacterStatusEnum;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'source_id';

    protected $keyType = 'int';

    protected $fillable = [
        'source_id', 'name',
        'status', 'gender',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'source_id' => 'integer',
            'status' => CharacterStatusEnum::class,
            'gender' => CharacterGenderEnum::class,
        ];
    }

    public static function nextSourceId(): int
    {
        $maxSourceId = static::query()->max('source_id');

        return $maxSourceId === null ? 1 : ((int) $maxSourceId) + 1;
    }
}
