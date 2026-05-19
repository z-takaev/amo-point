<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CharacterDTO;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class RickAndMortyService
{
    public function totalCharacters(): int
    {
        try {
            $response = Http::get($this->baseUrl().'/character');
        } catch (ConnectionException $exception) {
            Log::error('Rick and Morty API request failed.', [
                'endpoint' => '/character',
                'error' => $exception->getMessage(),
            ]);

            return 0;
        }

        if ($response->failed()) {
            Log::error('Rick and Morty API returned an error response.', [
                'endpoint' => '/character',
                'status' => $response->status(),
            ]);

            return 0;
        }

        return (int) $response->json('info.count', 0);
    }

    public function fetchCharacter(int $sourceId): ?CharacterDTO
    {
        try {
            $response = Http::get($this->baseUrl().'/character/'.$sourceId);
        } catch (ConnectionException $exception) {
            Log::error('Rick and Morty API request failed.', [
                'endpoint' => '/character/'.$sourceId,
                'error' => $exception->getMessage(),
            ]);

            return null;
        }

        if ($response->status() === 404) {
            return null;
        }

        if ($response->failed()) {
            Log::error('Rick and Morty API returned an error response.', [
                'endpoint' => '/character/'.$sourceId,
                'status' => $response->status(),
            ]);

            return null;
        }

        return CharacterDTO::fromPayload($response->json());
    }

    private function baseUrl(): string
    {
        return (string) config('rickandmorty.base_url');
    }
}
