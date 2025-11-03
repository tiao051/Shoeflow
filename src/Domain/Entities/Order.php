<?php

namespace Domain\Entities;

class Order
{
    public function __construct(
        public ?int $id,
        public string $orderNumber,
        public int $userId,
        public float $subtotal,
        public float $discount,
        public float $tax,
        public float $shippingFee,
        public float $total,
        public string $status,
        public string $paymentMethod,
        public string $paymentStatus,
        public string $recipientName,
        public string $recipientPhone,
        public string $shippingAddress,
        public ?string $notes,
        public array $items = []
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            orderNumber: $data['order_number'] ?? '',
            userId: $data['user_id'],
            subtotal: (float) $data['subtotal'],
            discount: (float) ($data['discount'] ?? 0),
            tax: (float) ($data['tax'] ?? 0),
            shippingFee: (float) ($data['shipping_fee'] ?? 0),
            total: (float) $data['total'],
            status: $data['status'] ?? 'pending',
            paymentMethod: $data['payment_method'] ?? 'cod',
            paymentStatus: $data['payment_status'] ?? 'unpaid',
            recipientName: $data['recipient_name'],
            recipientPhone: $data['recipient_phone'],
            shippingAddress: $data['shipping_address'],
            notes: $data['notes'] ?? null,
            items: $data['items'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->orderNumber,
            'user_id' => $this->userId,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'shipping_fee' => $this->shippingFee,
            'total' => $this->total,
            'status' => $this->status,
            'payment_method' => $this->paymentMethod,
            'payment_status' => $this->paymentStatus,
            'recipient_name' => $this->recipientName,
            'recipient_phone' => $this->recipientPhone,
            'shipping_address' => $this->shippingAddress,
            'notes' => $this->notes,
        ];
    }
}
