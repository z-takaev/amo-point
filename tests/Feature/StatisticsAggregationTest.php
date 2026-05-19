<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\VisitEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

it('exposes hourly unique visits and city counts to the statistics view', function (): void {
    $user = User::factory()->create();

    Carbon::setTestNow(Carbon::parse('2026-05-19 08:15:00'));
    VisitEvent::query()->create([
        'ip' => '203.0.113.10',
        'city' => 'Riyadh',
        'device' => 'mobile',
    ]);

    Carbon::setTestNow(Carbon::parse('2026-05-19 08:45:00'));
    VisitEvent::query()->create([
        'ip' => '203.0.113.11',
        'city' => 'Riyadh',
        'device' => 'desktop',
    ]);

    Carbon::setTestNow(Carbon::parse('2026-05-19 09:10:00'));
    VisitEvent::query()->create([
        'ip' => '203.0.113.10',
        'city' => 'Jeddah',
        'device' => 'tablet',
    ]);

    Carbon::setTestNow();

    $this->actingAs($user)
        ->get('/statistics')
        ->assertOk()
        ->assertViewHas('hourlyLabels', [
            '2026-05-19 08:00',
            '2026-05-19 09:00',
        ])
        ->assertViewHas('hourlyValues', [
            2,
            1,
        ])
        ->assertViewHas('cityLabels', [
            'Riyadh',
            'Jeddah',
        ])
        ->assertViewHas('cityValues', [
            2,
            1,
        ]);
});
