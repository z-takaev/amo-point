<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

it('protects the statistics page with auth middleware', function (): void {
    expect(Route::has('statistics'))->toBeTrue();
    expect(Route::getRoutes()->getByName('statistics')->gatherMiddleware())
        ->toContain('auth');

    $this->get('/statistics')
        ->assertRedirect('/login');
});

it('allows manual login and logout through the session guard', function (): void {
    $user = User::factory()->create([
        'password' => 'password',
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertRedirect('/statistics');

    $this->assertAuthenticatedAs($user);

    $this->post('/logout')
        ->assertRedirect('/login');

    $this->assertGuest();
});

it('applies rate limiting to the login endpoint', function (): void {
    expect(Route::has('login.perform'))->toBeTrue();
    expect(Route::getRoutes()->getByName('login.perform')->gatherMiddleware())
        ->toContain('throttle:login');
});
