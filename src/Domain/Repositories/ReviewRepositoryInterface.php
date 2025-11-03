<?php

namespace Domain\Repositories;

interface ReviewRepositoryInterface
{
    public function findByShoe(int $shoeId): array;
    
    public function findByUser(int $userId): array;
    
    public function create(array $data): bool;
    
    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
    
    public function approve(int $id): bool;
}
