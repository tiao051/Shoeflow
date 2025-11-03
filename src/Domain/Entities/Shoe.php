<?php

namespace Domain\Entities;

class Shoe
{
    public function __construct(
        public ?int $id,
        public int $categoryId,
        public string $name,
        public string $slug,
        public ?string $description,
        public string $brand,
        public ?string $material,
        public float $price,
        public ?float $discountPrice,
        public array $sizes,
        public int $stock,
        public ?string $mainImage,
        public array $images,
        public ?string $color,
        public bool $isFeatured,
        public bool $isActive,
        public float $rating,
        public int $reviewCount
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            categoryId: $data['category_id'],
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'] ?? null,
            brand: $data['brand'],
            material: $data['material'] ?? null,
            price: (float) $data['price'],
            discountPrice: isset($data['discount_price']) ? (float) $data['discount_price'] : null,
            sizes: is_string($data['sizes'] ?? []) ? json_decode($data['sizes'], true) : ($data['sizes'] ?? []),
            stock: $data['stock'] ?? 0,
            mainImage: $data['main_image'] ?? null,
            images: is_string($data['images'] ?? []) ? json_decode($data['images'], true) : ($data['images'] ?? []),
            color: $data['color'] ?? null,
            isFeatured: $data['is_featured'] ?? false,
            isActive: $data['is_active'] ?? true,
            rating: (float) ($data['rating'] ?? 0),
            reviewCount: $data['review_count'] ?? 0
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->categoryId,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'brand' => $this->brand,
            'material' => $this->material,
            'price' => $this->price,
            'discount_price' => $this->discountPrice,
            'sizes' => $this->sizes,
            'stock' => $this->stock,
            'main_image' => $this->mainImage,
            'images' => $this->images,
            'color' => $this->color,
            'is_featured' => $this->isFeatured,
            'is_active' => $this->isActive,
            'rating' => $this->rating,
            'review_count' => $this->reviewCount,
        ];
    }

    public function getFinalPrice(): float
    {
        return $this->discountPrice ?? $this->price;
    }

    public function hasDiscount(): bool
    {
        return $this->discountPrice !== null && $this->discountPrice < $this->price;
    }
}
