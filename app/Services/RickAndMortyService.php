<?php

declare(strict_types=1);

namespace App\Services;

use App\Client\RickAndMortyClient;
use App\DTO\CharacterDTO;

final class RickAndMortyService
{
    public function __construct(
        private readonly RickAndMortyClient $client,
    ) {}

    public function totalCharacters(): ?int
    {
        return $this->client->totalCharacters();
    }

    public function fetchCharacter(int $sourceId): ?CharacterDTO
    {
        $payload = $this->client->fetchCharacter($sourceId);

        if ($payload === null) {
            return null;
        }

        return CharacterDTO::fromPayload($payload);
    }
}
