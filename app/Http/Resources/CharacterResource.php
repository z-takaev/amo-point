<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CharacterResource extends JsonResource
{
    /**
     * @return array{source_id:int,name:string,status:string,gender:string,image:string}
     */
    public function toArray(Request $request): array
    {
        return [
            'source_id' => $this->source_id,
            'name' => $this->name,
            'status' => $this->status,
            'gender' => $this->gender,
            'image' => $this->image,
        ];
    }
}
