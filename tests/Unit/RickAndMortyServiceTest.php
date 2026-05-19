<?php

declare(strict_types=1);

use App\Enums\CharacterGenderEnum;
use App\Enums\CharacterStatusEnum;
use App\Services\RickAndMortyService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

uses(TestCase::class);

it('maps the remote payload into a character dto with enums', function (): void {
    Http::fake([
        'https://rickandmortyapi.com/api/character' => Http::response([
            'info' => ['count' => 42],
        ], 200),
        'https://rickandmortyapi.com/api/character/1' => Http::response([
            'id' => 1,
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'gender' => 'Male',
            'image' => 'https://rickandmortyapi.com/api/character/avatar/1.jpeg',
        ], 200),
    ]);

    $service = app(RickAndMortyService::class);

    expect($service->totalCharacters())->toBe(42);

    $character = $service->fetchCharacter(1);

    expect($character?->sourceId)->toBe(1)
        ->and($character?->name)->toBe('Rick Sanchez')
        ->and($character?->status)->toBe(CharacterStatusEnum::Alive)
        ->and($character?->gender)->toBe(CharacterGenderEnum::Male)
        ->and($character?->image)->toBe('https://rickandmortyapi.com/api/character/avatar/1.jpeg');
});

it('returns null for missing characters', function (): void {
    Http::fake([
        'https://rickandmortyapi.com/api/character' => Http::response([
            'info' => ['count' => 1],
        ], 200),
        'https://rickandmortyapi.com/api/character/1' => Http::response([], 404),
    ]);

    expect(app(RickAndMortyService::class)->fetchCharacter(1))->toBeNull();
});

it('logs api errors and returns safe defaults', function (): void {
    Log::spy();

    Http::fake([
        'https://rickandmortyapi.com/api/character' => Http::response([], 500),
        'https://rickandmortyapi.com/api/character/1' => Http::response([], 500),
    ]);

    $service = app(RickAndMortyService::class);

    expect($service->totalCharacters())->toBeNull()
        ->and($service->fetchCharacter(1))->toBeNull();

    Log::shouldHaveReceived('error')->twice();
});
