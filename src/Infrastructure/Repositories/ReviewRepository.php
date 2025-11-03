<?php

namespace Infrastructure\Repositories;

use App\Models\Review;
use Domain\Repositories\ReviewRepositoryInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function findByShoe(int $shoeId): array
    {
        return Review::where('shoe_id', $shoeId)
            ->where('is_approved', true)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function findByUser(int $userId): array
    {
        return Review::where('user_id', $userId)
            ->with(['shoe', 'order'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function create(array $data): bool
    {
        return Review::create($data) ? true : false;
    }

    public function update(int $id, array $data): bool
    {
        $review = Review::findOrFail($id);
        return $review->update($data);
    }

    public function delete(int $id): bool
    {
        return Review::destroy($id) > 0;
    }

    public function approve(int $id): bool
    {
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        return $review->save();
    }
}
