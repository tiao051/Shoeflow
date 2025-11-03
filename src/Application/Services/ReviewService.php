<?php

namespace Application\Services;

use Domain\Repositories\ReviewRepositoryInterface;
use Domain\Repositories\ShoeRepositoryInterface;

class ReviewService
{
    public function __construct(
        private ReviewRepositoryInterface $reviewRepository,
        private ShoeRepositoryInterface $shoeRepository
    ) {}

    public function getShoeReviews(int $shoeId): array
    {
        return $this->reviewRepository->findByShoe($shoeId);
    }

    public function getUserReviews(int $userId): array
    {
        return $this->reviewRepository->findByUser($userId);
    }

    public function createReview(array $data): bool
    {
        $result = $this->reviewRepository->create($data);
        
        if ($result) {
            // Update shoe rating
            $this->shoeRepository->updateRating($data['shoe_id']);
        }
        
        return $result;
    }

    public function updateReview(int $id, array $data): bool
    {
        $result = $this->reviewRepository->update($id, $data);
        
        if ($result && isset($data['rating'])) {
            // Update shoe rating if rating changed
            $review = $this->reviewRepository->findByUser($data['user_id']);
            if (!empty($review)) {
                $this->shoeRepository->updateRating($review[0]['shoe_id']);
            }
        }
        
        return $result;
    }

    public function deleteReview(int $id, int $shoeId): bool
    {
        $result = $this->reviewRepository->delete($id);
        
        if ($result) {
            $this->shoeRepository->updateRating($shoeId);
        }
        
        return $result;
    }
}
