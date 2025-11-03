<?php

namespace Domain\Repositories;

use Domain\Entities\Shoe;

interface ShoeRepositoryInterface
{
    public function findAll(): array;
    
    public function findActive(): array;
    
    public function findFeatured(int $limit = 8): array;
    
    public function findById(int $id): ?Shoe;
    
    public function findBySlug(string $slug): ?Shoe;
    
    public function findByCategory(int $categoryId, int $perPage = 12): array;
    
    public function search(array $filters, int $perPage = 12): array;
    
    public function create(array $data): Shoe;
    
    public function update(int $id, array $data): Shoe;
    
    public function delete(int $id): bool;
    
    public function updateStock(int $id, int $quantity): bool;
    
    public function updateRating(int $id): bool;
}
