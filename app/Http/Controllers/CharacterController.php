<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
use App\Models\Character;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class CharacterController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $characters = Character::query()
            ->select(['source_id', 'name', 'status', 'gender', 'image'])
            ->paginate(config('rickandmorty.per_page'));

        return CharacterResource::collection($characters);
    }
}
