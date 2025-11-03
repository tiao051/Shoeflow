<?php

namespace Infrastructure\Repositories;

use App\Models\Promotion;
use Domain\Repositories\PromotionRepositoryInterface;

class PromotionRepository implements PromotionRepositoryInterface
{
    public function findAll(): array
    {
        return Promotion::orderBy('created_at', 'desc')->get()->toArray();
    }

    public function findActive(): array
    {
        return Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get()
            ->toArray();
    }

    public function findByCode(string $code): ?array
    {
        $promotion = Promotion::where('code', $code)->first();
        return $promotion ? $promotion->toArray() : null;
    }

    public function create(array $data): bool
    {
        return Promotion::create($data) ? true : false;
    }

    public function update(int $id, array $data): bool
    {
        $promotion = Promotion::findOrFail($id);
        return $promotion->update($data);
    }

    public function delete(int $id): bool
    {
        return Promotion::destroy($id) > 0;
    }

    public function incrementUsage(int $id): bool
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->increment('used_count');
        return true;
    }

    public function validatePromotion(string $code, float $orderTotal): array
    {
        $promotion = Promotion::where('code', $code)->first();

        if (!$promotion) {
            return ['valid' => false, 'message' => 'Promotion code not found'];
        }

        if (!$promotion->isValid()) {
            return ['valid' => false, 'message' => 'Promotion code is not valid or has expired'];
        }

        if ($orderTotal < $promotion->min_purchase) {
            return [
                'valid' => false,
                'message' => "Minimum purchase of Rp " . number_format($promotion->min_purchase, 0, ',', '.') . " required"
            ];
        }

        $discount = $promotion->calculateDiscount($orderTotal);

        return [
            'valid' => true,
            'promotion_id' => $promotion->id,
            'discount' => $discount,
            'message' => 'Promotion applied successfully'
        ];
    }
}
