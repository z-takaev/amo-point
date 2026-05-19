<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
use App\Models\Character;
use Illuminate\Http\Resources\Json\JsonResource;

final class CharacterController extends Controller
{
    public function index(): JsonResource
    {
        $characters = Character::query()
            ->paginate(config('rickandmorty.per_page'));

        return CharacterResource::collection($characters);
    }
}
