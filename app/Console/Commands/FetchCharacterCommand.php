<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Character;
use App\Services\RickAndMortyService;
use Illuminate\Console\Command;

final class FetchCharacterCommand extends Command
{
    protected $signature = 'fetch:character';

    protected $description = 'Загрузить следующего персонажа';

    public function handle(RickAndMortyService $service): int
    {
        $this->fetchNextCharacter($service);

        return self::SUCCESS;
    }

    private function fetchNextCharacter(RickAndMortyService $service): void
    {
        $nextSourceId = $this->nextSourceId();
        $totalCharacters = $service->totalCharacters();

        if ($nextSourceId > $totalCharacters) {
            return;
        }

        for ($sourceId = $nextSourceId; $sourceId <= $totalCharacters; $sourceId++) {
            $character = $service->fetchCharacter($sourceId);

            if ($character === null) {
                continue;
            }

            Character::query()->updateOrCreate(
                ['source_id' => $sourceId],
                $character->toModelAttributes(),
            );

            return;
        }
    }

    private function nextSourceId(): int
    {
        $maxSourceId = Character::query()->max('source_id');

        return $maxSourceId === null ? 1 : ((int) $maxSourceId) + 1;
    }
}
