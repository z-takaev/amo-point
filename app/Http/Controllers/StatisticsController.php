<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\VisitEvent;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

final class StatisticsController extends Controller
{
    public function index(): View
    {
        $events = Schema::hasTable('visit_events')
            ? VisitEvent::query()
                ->orderBy('created_at')
                ->get(['ip', 'city', 'created_at'])
            : collect();

        $hourlyVisits = $events
            ->groupBy(static fn (VisitEvent $event): string => $event->created_at->format('Y-m-d H:00'))
            ->map(static fn ($hourEvents): int => $hourEvents->pluck('ip')->unique()->count())
            ->sortKeys();

        $cityVisits = $events
            ->groupBy('city')
            ->map(static fn ($cityEvents): int => $cityEvents->count())
            ->sortDesc();

        return view('statistics', [
            'hourlyLabels' => $hourlyVisits->keys()->values()->all(),
            'hourlyValues' => $hourlyVisits->values()->all(),
            'cityLabels' => $cityVisits->keys()->values()->all(),
            'cityValues' => $cityVisits->values()->all(),
            'totalVisits' => $events->count(),
        ]);
    }
}
