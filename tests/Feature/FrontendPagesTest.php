<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('loads the home page with links to the dashboard and login', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee('Панель блоков и статистики', false)
        ->assertSee(route('statistics.index'), false)
        ->assertSee(route('login'), false);
});

it('loads the login page', function (): void {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee(route('login.perform'), false)
        ->assertSee('name="email"', false)
        ->assertSee('name="password"', false)
        ->assertSee('Запомнить меня', false);
});

it('loads the statistics page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('statistics.index'))
        ->assertOk()
        ->assertSee('Статистика посещений', false)
        ->assertSee('cdn.jsdelivr.net/npm/chart.js', false)
        ->assertSee('hourly-visits-chart', false)
        ->assertSee('city-distribution-chart', false);
});
