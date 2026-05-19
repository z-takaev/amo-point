<?php

declare(strict_types=1);

use App\Client\RickAndMortyClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

uses(TestCase::class);

it('returns total characters from the api', function (): void {
    Http::fake([
        'https://rickandmortyapi.com/api/character' => Http::response([
            'info' => ['count' => 42],
        ], 200),
    ]);

    expect(app(RickAndMortyClient::class)->totalCharacters())->toBe(42);
});

it('returns payload for an existing character', function (): void {
    Http::fake([
        'https://rickandmortyapi.com/api/character/1' => Http::response([
            'id' => 1,
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'gender' => 'Male',
            'image' => 'https://rickandmortyapi.com/api/character/avatar/1.jpeg',
        ], 200),
    ]);

    expect(app(RickAndMortyClient::class)->fetchCharacter(1))->toBe([
        'id' => 1,
        'name' => 'Rick Sanchez',
        'status' => 'Alive',
        'gender' => 'Male',
        'image' => 'https://rickandmortyapi.com/api/character/avatar/1.jpeg',
    ]);
});

it('logs api errors and returns safe defaults', function (): void {
    Log::spy();

    Http::fake([
        'https://rickandmortyapi.com/api/character' => Http::response([], 500),
        'https://rickandmortyapi.com/api/character/1' => Http::response([], 500),
    ]);

    $client = app(RickAndMortyClient::class);

    expect($client->totalCharacters())->toBeNull()
        ->and($client->fetchCharacter(1))->toBeNull();

    Log::shouldHaveReceived('error')->twice();
});
