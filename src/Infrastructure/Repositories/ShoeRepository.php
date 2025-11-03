<?php

namespace Infrastructure\Repositories;

use App\Models\Shoe as ShoeModel;
use Domain\Entities\Shoe;
use Domain\Repositories\ShoeRepositoryInterface;

class ShoeRepository implements ShoeRepositoryInterface
{
    public function findAll(): array
    {
        return ShoeModel::with('category')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($model) => Shoe::fromArray($model->toArray()))
            ->toArray();
    }

    public function findActive(): array
    {
        return ShoeModel::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($model) => Shoe::fromArray($model->toArray()))
            ->toArray();
    }

    public function findFeatured(int $limit = 8): array
    {
        return ShoeModel::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->limit($limit)
            ->get()
            ->map(fn($model) => Shoe::fromArray($model->toArray()))
            ->toArray();
    }

    public function findById(int $id): ?Shoe
    {
        $model = ShoeModel::with('category')->find($id);
        return $model ? Shoe::fromArray($model->toArray()) : null;
    }

    public function findBySlug(string $slug): ?Shoe
    {
        $model = ShoeModel::with('category')->where('slug', $slug)->first();
        return $model ? Shoe::fromArray($model->toArray()) : null;
    }

    public function findByCategory(int $categoryId, int $perPage = 12): array
    {
        $paginated = ShoeModel::where('category_id', $categoryId)
            ->where('is_active', true)
            ->with('category')
            ->paginate($perPage);

        return [
            'data' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
        ];
    }

    public function search(array $filters, int $perPage = 12): array
    {
        $query = ShoeModel::with('category')->where('is_active', true);

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('brand', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['brand'])) {
            $query->where('brand', $filters['brand']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (!empty($filters['size'])) {
            $query->whereJsonContains('sizes', $filters['size']);
        }

        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $paginated = $query->paginate($perPage);

        return [
            'data' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
        ];
    }

    public function create(array $data): Shoe
    {
        $model = ShoeModel::create($data);
        return Shoe::fromArray($model->toArray());
    }

    public function update(int $id, array $data): Shoe
    {
        $model = ShoeModel::findOrFail($id);
        $model->update($data);
        return Shoe::fromArray($model->fresh()->toArray());
    }

    public function delete(int $id): bool
    {
        return ShoeModel::destroy($id) > 0;
    }

    public function updateStock(int $id, int $quantity): bool
    {
        $model = ShoeModel::findOrFail($id);
        $model->stock = $quantity;
        return $model->save();
    }

    public function updateRating(int $id): bool
    {
        $model = ShoeModel::findOrFail($id);
        $reviews = $model->approvedReviews;
        
        if ($reviews->count() > 0) {
            $model->rating = $reviews->avg('rating');
            $model->review_count = $reviews->count();
        } else {
            $model->rating = 0;
            $model->review_count = 0;
        }
        
        return $model->save();
    }
}
