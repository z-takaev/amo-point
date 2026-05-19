<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\VisitEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class VisitEventController extends Controller
{
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'ip' => ['required', 'ip'],
            'city' => ['required', 'string', 'max:255'],
            'device' => ['required', 'string', 'max:255'],
        ]);

        VisitEvent::query()->create([
            'ip' => $validated['ip'],
            'city' => $validated['city'],
            'device' => $validated['device'],
        ]);

        return response()->noContent();
    }
}
