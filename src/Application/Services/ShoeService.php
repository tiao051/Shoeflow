<?php

namespace Application\Services;

use Domain\Repositories\ShoeRepositoryInterface;
use Domain\Repositories\CategoryRepositoryInterface;

class ShoeService
{
    public function __construct(
        private ShoeRepositoryInterface $shoeRepository,
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getFeaturedShoes(int $limit = 8): array
    {
        return $this->shoeRepository->findFeatured($limit);
    }

    public function getShoeBySlug(string $slug): ?array
    {
        $shoe = $this->shoeRepository->findBySlug($slug);
        return $shoe ? $shoe->toArray() : null;
    }

    public function searchShoes(array $filters, int $perPage = 12): array
    {
        return $this->shoeRepository->search($filters, $perPage);
    }

    public function getShoesByCategory(int $categoryId, int $perPage = 12): array
    {
        return $this->shoeRepository->findByCategory($categoryId, $perPage);
    }

    public function getAllShoes(): array
    {
        return $this->shoeRepository->findAll();
    }

    public function createShoe(array $data): array
    {
        $shoe = $this->shoeRepository->create($data);
        return $shoe->toArray();
    }

    public function updateShoe(int $id, array $data): array
    {
        $shoe = $this->shoeRepository->update($id, $data);
        return $shoe->toArray();
    }

    public function deleteShoe(int $id): bool
    {
        return $this->shoeRepository->delete($id);
    }

    public function getAvailableBrands(): array
    {
        // This could be enhanced to fetch from database
        return ['Nike', 'Adidas', 'Puma', 'Reebok', 'New Balance', 'Converse', 'Vans'];
    }

    public function getAvailableSizes(): array
    {
        return ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
    }
}
