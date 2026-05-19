<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

it('stores raw visit events through the public ingest endpoint', function (): void {
    $payload = [
        'ip' => '203.0.113.10',
        'city' => 'Riyadh',
        'device' => 'mobile',
    ];

    $this->postJson('/api/visits', $payload)
        ->assertNoContent();

    $this->assertDatabaseHas('visit_events', [
        'ip' => $payload['ip'],
        'city' => $payload['city'],
        'device' => $payload['device'],
    ]);
});

it('requires ip and city from the tracker payload', function (): void {
    $this->postJson('/api/visits', [
        'device' => 'desktop',
    ])->assertInvalid([
        'ip' => 'required',
        'city' => 'required',
    ]);
});

it('applies rate limiting to the visit ingest endpoint', function (): void {
    expect(Route::has('visits.store'))->toBeTrue();
    expect(Route::getRoutes()->getByName('visits.store')->gatherMiddleware())
        ->toContain('throttle:visits');
});
