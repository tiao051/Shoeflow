<?php

namespace Infrastructure\Repositories;

use App\Models\Category as CategoryModel;
use Domain\Entities\Category;
use Domain\Repositories\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findAll(): array
    {
        return CategoryModel::orderBy('name')->get()
            ->map(fn($model) => Category::fromArray($model->toArray()))
            ->toArray();
    }

    public function findActive(): array
    {
        return CategoryModel::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(fn($model) => Category::fromArray($model->toArray()))
            ->toArray();
    }

    public function findById(int $id): ?Category
    {
        $model = CategoryModel::find($id);
        return $model ? Category::fromArray($model->toArray()) : null;
    }

    public function findBySlug(string $slug): ?Category
    {
        $model = CategoryModel::where('slug', $slug)->first();
        return $model ? Category::fromArray($model->toArray()) : null;
    }

    public function create(array $data): Category
    {
        $model = CategoryModel::create($data);
        return Category::fromArray($model->toArray());
    }

    public function update(int $id, array $data): Category
    {
        $model = CategoryModel::findOrFail($id);
        $model->update($data);
        return Category::fromArray($model->fresh()->toArray());
    }

    public function delete(int $id): bool
    {
        return CategoryModel::destroy($id) > 0;
    }

    public function paginate(int $perPage = 15): array
    {
        $paginated = CategoryModel::orderBy('created_at', 'desc')->paginate($perPage);
        
        return [
            'data' => $paginated->items(),
            'total' => $paginated->total(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
        ];
    }
}
