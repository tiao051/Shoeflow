<?php

namespace Domain\Repositories;

interface PromotionRepositoryInterface
{
    public function findAll(): array;
    
    public function findActive(): array;
    
    public function findByCode(string $code): ?array;
    
    public function create(array $data): bool;
    
    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
    
    public function incrementUsage(int $id): bool;
    
    public function validatePromotion(string $code, float $orderTotal): array;
}
