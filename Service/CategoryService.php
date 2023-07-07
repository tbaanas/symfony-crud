<?php

namespace App\Service;


use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryService
{
    private CategoriesRepository $categoryRepository;

    public function __construct(CategoriesRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /*
     * Get All Categories from DB to Twig List
     */
    public function getAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getOneCategory(int $id): Categories
    {
        return $this->categoryRepository->findOneBy(['id'=>$id]);
    }

    public function getOneCategoryByName(string $name): ?Categories
    {
        return $this->categoryRepository->findOneBy(['name'=>$name]);
    }

    public function update(Categories $getData): bool
    {
        $this->categoryRepository->save($getData,true);
        return true;
    }

    public function delete(int $id, bool $isGranted): bool
    {

        $categoryToDelete = $this->categoryRepository->findOneBy(['id'=>$id]);

        if ($categoryToDelete === null) {
            throw new NotFoundHttpException('Category not exist.', null, 404);
        }
        if ($isGranted && $categoryToDelete != null) {
            $this->categoryRepository->remove($categoryToDelete, true);
            return true;
        }
        return false;

    }

    public function getCategoriesOptions(): array
    {
        $categories = $this->categoryRepository->findAll();
        $categoryOptions = array();
        foreach ($categories as $category) {
            $categoryOptions[$category->getName()] = $category->getName();
        }
        return $categoryOptions;
    }

    public function getCategoryById($categoryId):Categories
    {
        return $this->categoryRepository->find($categoryId);
    }


}