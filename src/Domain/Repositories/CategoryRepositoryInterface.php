<?php

namespace Domain\Repositories;

use Domain\Entities\Category;

interface CategoryRepositoryInterface
{
    public function findAll(): array;
    
    public function findActive(): array;
    
    public function findById(int $id): ?Category;
    
    public function findBySlug(string $slug): ?Category;
    
    public function create(array $data): Category;
    
    public function update(int $id, array $data): Category;
    
    public function delete(int $id): bool;
    
    public function paginate(int $perPage = 15): array;
}
