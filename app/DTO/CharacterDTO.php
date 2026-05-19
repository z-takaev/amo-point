<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\CharacterGenderEnum;
use App\Enums\CharacterStatusEnum;

final readonly class CharacterDTO
{
    public function __construct(
        public int $sourceId,
        public string $name,
        public CharacterStatusEnum $status,
        public CharacterGenderEnum $gender,
        public string $image,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): self
    {
        return new self(
            sourceId: (int) $payload['id'],
            name: (string) $payload['name'],
            status: CharacterStatusEnum::fromValue((string) $payload['status']),
            gender: CharacterGenderEnum::fromValue((string) $payload['gender']),
            image: (string) $payload['image'],
        );
    }

    /**
     * @return array{source_id:int,name:string,status:string,gender:string,image:string}
     */
    public function toArray(): array
    {
        return [
            'source_id' => $this->sourceId,
            'name' => $this->name,
            'status' => $this->status->value,
            'gender' => $this->gender->value,
            'image' => $this->image,
        ];
    }
}
