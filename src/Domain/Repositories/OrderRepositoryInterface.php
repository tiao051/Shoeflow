<?php

namespace Domain\Repositories;

use Domain\Entities\Order;

interface OrderRepositoryInterface
{
    public function findAll(int $perPage = 15): array;
    
    public function findById(int $id): ?Order;
    
    public function findByOrderNumber(string $orderNumber): ?Order;
    
    public function findByUser(int $userId, int $perPage = 10): array;
    
    public function create(array $orderData, array $items): Order;
    
    public function updateStatus(int $id, string $status): bool;
    
    public function updatePaymentStatus(int $id, string $paymentStatus): bool;
    
    public function getStatistics(array $filters = []): array;
}
