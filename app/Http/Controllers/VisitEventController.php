<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\VisitEvent;
use App\Http\Requests\VisitEventRequest;
use Illuminate\Http\Response;

final class VisitEventController extends Controller
{
    public function store(VisitEventRequest $request): Response
    {
        $validated = $request->validated();

        VisitEvent::query()->create([
            'ip' => $validated['ip'],
            'city' => $validated['city'],
            'device' => $validated['device'],
        ]);

        return response()->noContent();
    }
}
