<?php

namespace Domain\Entities;

class Category
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $slug,
        public ?string $description,
        public ?string $image,
        public bool $isActive
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'] ?? null,
            image: $data['image'] ?? null,
            isActive: $data['is_active'] ?? true
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'is_active' => $this->isActive,
        ];
    }
}
