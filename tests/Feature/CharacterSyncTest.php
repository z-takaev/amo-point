<?php

declare(strict_types=1);

use App\Enums\CharacterGenderEnum;
use App\Enums\CharacterStatusEnum;
use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

it('persists character attributes', function (): void {
    $character = Character::query()->create([
        'source_id' => 10,
        'name' => 'Rick Sanchez',
        'status' => CharacterStatusEnum::Alive,
        'gender' => CharacterGenderEnum::Male,
        'image' => 'https://rickandmortyapi.com/api/character/avatar/10.jpeg',
    ]);

    expect($character->source_id)->toBe(10)
        ->and($character->name)->toBe('Rick Sanchez')
        ->and($character->status)->toBe(CharacterStatusEnum::Alive)
        ->and($character->gender)->toBe(CharacterGenderEnum::Male)
        ->and($character->image)->toBe('https://rickandmortyapi.com/api/character/avatar/10.jpeg');
});

it('fetches the next sequential character without duplicating source ids', function (): void {
    Character::query()->create([
        'source_id' => 1,
        'name' => 'Rick Sanchez',
        'status' => CharacterStatusEnum::Alive,
        'gender' => CharacterGenderEnum::Male,
        'image' => 'https://rickandmortyapi.com/api/character/avatar/1.jpeg',
    ]);

    Http::fake([
        'https://rickandmortyapi.com/api/character' => Http::response([
            'info' => ['count' => 3],
        ], 200),
        'https://rickandmortyapi.com/api/character/2' => Http::response([], 404),
        'https://rickandmortyapi.com/api/character/3' => Http::response([
            'id' => 3,
            'name' => 'Summer Smith',
            'status' => 'Alive',
            'gender' => 'Female',
            'image' => 'https://rickandmortyapi.com/api/character/avatar/3.jpeg',
        ], 200),
    ]);

    $this->artisan('fetch:character')->assertExitCode(0);

    expect(Character::query()->pluck('source_id')->all())->toBe([1, 3]);

    $this->assertDatabaseHas('characters', [
        'source_id' => 3,
        'name' => 'Summer Smith',
        'status' => CharacterStatusEnum::Alive->value,
        'gender' => CharacterGenderEnum::Female->value,
        'image' => 'https://rickandmortyapi.com/api/character/avatar/3.jpeg',
    ]);

    Http::assertSentInOrder([
        fn (Request $request): bool => $request->url() === 'https://rickandmortyapi.com/api/character',
        fn (Request $request): bool => $request->url() === 'https://rickandmortyapi.com/api/character/2',
        fn (Request $request): bool => $request->url() === 'https://rickandmortyapi.com/api/character/3',
    ]);
});

it('returns stored characters through pagination and exposes throttling', function (): void {
    collect(range(1, 16))->each(function (int $sourceId): void {
        Character::query()->create([
            'source_id' => $sourceId,
            'name' => 'Character '.$sourceId,
            'status' => CharacterStatusEnum::Alive,
            'gender' => CharacterGenderEnum::Male,
            'image' => 'https://rickandmortyapi.com/api/character/avatar/'.$sourceId.'.jpeg',
        ]);
    });

    $this->getJson('/api/characters?page=2')
        ->assertOk()
        ->assertJsonPath('meta.current_page', 2)
        ->assertJsonPath('meta.per_page', 15)
        ->assertJsonPath('meta.total', 16)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.source_id', 16)
        ->assertJsonPath('data.0.name', 'Character 16')
        ->assertJsonPath('data.0.status', CharacterStatusEnum::Alive->value)
        ->assertJsonPath('data.0.gender', CharacterGenderEnum::Male->value)
        ->assertJsonPath('data.0.image', 'https://rickandmortyapi.com/api/character/avatar/16.jpeg');

    expect(Route::getRoutes()->getByName('characters')?->gatherMiddleware())->toContain('throttle:characters');
});
