<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('loads the home page with links to the dashboard and login', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertSee(route('statistics'), false);
});

it('loads the login page', function (): void {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee(route('login.perform'), false)
        ->assertSee('name="email"', false)
        ->assertSee('name="password"', false);
});

it('redirects authenticated users away from the login page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('login'))
        ->assertRedirect(route('dashboard'));
});

it('loads the statistics page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('statistics'))
        ->assertOk()
        ->assertSee('Статистика посещений', false)
        ->assertSee('cdn.jsdelivr.net/npm/chart.js', false)
        ->assertSee('hourly-visits-chart', false)
        ->assertSee('city-distribution-chart', false);
});
