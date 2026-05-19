<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\VisitEvent;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

final class StatisticsController extends Controller
{
    public function index(): View
    {
        $events = VisitEvent::query()
            ->orderBy('created_at', 'desc')
            ->get(['ip', 'city', 'created_at']);

        $hourlyVisits = $events
            ->groupBy(static fn (VisitEvent $event): string => $event->created_at->format('Y-m-d H:00'))
            ->map(static fn (Collection $hourEvents): int => $hourEvents->pluck('ip')->unique()->count())
            ->sortKeys();

        $cityVisits = $events
            ->groupBy('city')
            ->map(static fn (Collection $cityEvents): int => $cityEvents->count())
            ->sortDesc();

        return view('statistics', [
            'hourlyLabels' => $hourlyVisits->keys()->all(),
            'hourlyValues' => $hourlyVisits->values()->all(),
            'cityLabels' => $cityVisits->keys()->all(),
            'cityValues' => $cityVisits->values()->all(),
        ]);
    }
}
