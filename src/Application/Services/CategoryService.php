<?php

namespace Application\Services;

use Domain\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getActiveCategories(): array
    {
        return $this->categoryRepository->findActive();
    }

    public function getCategoryBySlug(string $slug): ?array
    {
        $category = $this->categoryRepository->findBySlug($slug);
        return $category ? $category->toArray() : null;
    }

    public function createCategory(array $data): array
    {
        $category = $this->categoryRepository->create($data);
        return $category->toArray();
    }

    public function updateCategory(int $id, array $data): array
    {
        $category = $this->categoryRepository->update($id, $data);
        return $category->toArray();
    }

    public function deleteCategory(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }

    public function paginateCategories(int $perPage = 15): array
    {
        return $this->categoryRepository->paginate($perPage);
    }
}
