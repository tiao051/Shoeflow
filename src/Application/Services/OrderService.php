<?php

namespace Application\Services;

use Domain\Repositories\OrderRepositoryInterface;
use Domain\Repositories\ShoeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private ShoeRepositoryInterface $shoeRepository
    ) {}

    public function createOrder(array $orderData, array $cartItems): array
    {
        return DB::transaction(function () use ($orderData, $cartItems) {
            // Prepare order items
            $items = [];
            foreach ($cartItems as $item) {
                $shoe = $this->shoeRepository->findById($item['shoe_id']);
                
                if (!$shoe || $shoe->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for shoe: {$item['shoe_name']}");
                }

                $items[] = [
                    'shoe_id' => $item['shoe_id'],
                    'shoe_name' => $item['shoe_name'],
                    'shoe_image' => $item['shoe_image'],
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ];

                // Reduce stock
                $newStock = $shoe->stock - $item['quantity'];
                $this->shoeRepository->updateStock($item['shoe_id'], $newStock);
            }

            // Create order
            $order = $this->orderRepository->create($orderData, $items);

            return $order->toArray();
        });
    }

    public function getUserOrders(int $userId, int $perPage = 10): array
    {
        return $this->orderRepository->findByUser($userId, $perPage);
    }

    public function getOrderByNumber(string $orderNumber): ?array
    {
        $order = $this->orderRepository->findByOrderNumber($orderNumber);
        return $order ? $order->toArray() : null;
    }

    public function getAllOrders(int $perPage = 15): array
    {
        return $this->orderRepository->findAll($perPage);
    }

    public function updateOrderStatus(int $id, string $status): bool
    {
        return $this->orderRepository->updateStatus($id, $status);
    }

    public function updatePaymentStatus(int $id, string $paymentStatus): bool
    {
        return $this->orderRepository->updatePaymentStatus($id, $paymentStatus);
    }

    public function getStatistics(array $filters = []): array
    {
        return $this->orderRepository->getStatistics($filters);
    }

    public function calculateOrderTotal(array $cartItems, float $discount = 0, float $shippingFee = 0): array
    {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['subtotal'];
        }

        $tax = $subtotal * 0.11; // 11% tax
        $total = $subtotal - $discount + $tax + $shippingFee;

        return [
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'tax' => round($tax, 2),
            'shipping_fee' => round($shippingFee, 2),
            'total' => round($total, 2),
        ];
    }
}
