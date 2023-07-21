<?php

namespace App\Service;

use App\Entity\ArticleCategory;
use App\Repository\ArticleCategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleCategoryService
{
    public function __construct(public ArticleCategoryRepository $repository)
    {
    }

    /*
     * Get All Categories from DB to Twig List
     */
    public function getAllCategories(): array
    {
        return $this->repository->findAll();
    }

    public function getOneCategory(int $id): ArticleCategory
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function getOneCategoryByName(string $name): ?ArticleCategory
    {
        return $this->repository->findOneBy(['name' => $name]);
    }

    public function update(ArticleCategory $getData): bool
    {
        $this->repository->save($getData, true);

        return true;
    }

    public function delete(int $id, bool $isGranted): bool
    {
        $categoryToDelete = $this->repository->findOneBy(['id' => $id]);

        if (null === $categoryToDelete) {
            throw new NotFoundHttpException('Category not exist.', null, 404);
        }
        if ($isGranted && null != $categoryToDelete) {
            $this->repository->remove($categoryToDelete, true);

            return true;
        }

        return false;
    }

    public function getCategoriesOptions(): array
    {
        $categories = $this->repository->findAll();
        $categoryOptions = [];
        foreach ($categories as $category) {
            $categoryOptions[$category->getName()] = $category->getName();
        }

        return $categoryOptions;
    }

    public function getCategoryById($categoryId): ArticleCategory
    {
        return $this->repository->find($categoryId);
    }
}
