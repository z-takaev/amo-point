<?php

declare(strict_types=1);

namespace App\Client;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class RickAndMortyClient
{
    public function totalCharacters(): ?int
    {
        try {
            $response = Http::get($this->baseUrl().'/character');
        } catch (ConnectionException $exception) {
            Log::error('Rick and Morty API request failed.', [
                'endpoint' => '/character',
                'error' => $exception->getMessage(),
            ]);

            return null;
        }

        if ($response->failed()) {
            Log::error('Rick and Morty API returned an error response.', [
                'endpoint' => '/character',
                'status' => $response->status(),
            ]);

            return null;
        }

        return (int) $response->json('info.count', 0);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function fetchCharacter(int $sourceId): ?array
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

        /** @var array<string, mixed> $payload */
        $payload = $response->json();

        return $payload;
    }

    private function baseUrl(): string
    {
        return (string) config('rickandmorty.base_url');
    }
}
