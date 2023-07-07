<?php

namespace App\Controller\admin\category;

use App\Form\CategoryEditFormType;
use App\Service\CategoryService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminCategoryController extends AbstractController
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }




    #[Route('/admin/category', name: 'admin_categories')]
    public function index(): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $this->categoryService->getAllCategories(),
        ]);
    }


    #[Route('/admin/category/{id}', name: 'admin_category_view',methods: ['GET'])]
    public function getOneCategory(int $id): Response
    {
        $category=$this->categoryService->getOneCategory($id);
        return $this->render('admin/category/viewCategory.html.twig', [
            'category' => $category,
            'categorySeo'=>$category->getCategorySeoData()
        ]);
    }


    #[Route('/admin/category/edit/{name}', name: 'admin_category_edit',methods: ['GET'])]
    public function editOneCategory(string $name): Response
    {
        $category=$this->categoryService->getOneCategoryByName($name);
        $form = $this->createForm(CategoryEditFormType::class);
        $form->setData($category);


        return $this->render('admin/category/editCategory.html.twig', [
            'category' => $category,
            'categorySeo'=>$category->getCategorySeoData(),
            'form' => $form->createView(),

        ]);
    }


    #[Route('/admin/category/edit/{name}', name: 'admin_category_edit_post', methods: ['POST'])]
    public function updateOneCategory(Request $request,string $name): Response
    {
        $category = $this->categoryService->getOneCategoryByName($name);
        $form = $this->createForm(CategoryEditFormType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->update($form->getData());
            $this->addFlash('success', 'Kategoria została poprawnie edytowana.');
            return $this->redirectToRoute('admin_categories');
        }
        $this->addFlash('error', 'Wystąpił błąd :(');
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                echo $error->getMessage()."<br>";
              //  var_dump($error->getMessage());
            }
        }

        return $this->redirectToRoute('admin_categories');
    }


    #[Route('/admin/category/save', name: 'admin_category_save_new_form', methods: ['GET'],priority: 1)]
    public function saveNewCategoryForm(): Response
    {
        $form = $this->createForm(CategoryEditFormType::class);


        return $this->render('admin/category/addCategory.html.twig', [
            'form' => $form->createView(),

        ]);
    }




    #[Route('/admin/category/save', name: 'admin_category_save_new', methods: ['POST'],priority: 2)]
    public function saveNewCategory(Request $request): Response
    {
        $form = $this->createForm(CategoryEditFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->update($form->getData());
            $this->addFlash('success', 'Kategoria została poprawnie edytowana.');
            return $this->redirectToRoute('admin_categories');
        }
        $this->addFlash('error', 'Wystąpił błąd :(');
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                echo $error->getMessage()."<br>";
              //  var_dump($error->getMessage());
            }
        }

        return $this->redirectToRoute('admin_categories');
    }


    #[Route('/admin/category/{id}/delete', name: 'admin_category_delete',methods: ['POST'])]
    public function deleteCategory(int $id, Security $security): Response
    {

        $status = $this->categoryService->delete($id, $security->isGranted('ROLE_ADMIN'));

        if ($status) {
            $this->addFlash('success', 'Kategoria została usunięta.');
        } else
            $this->addFlash('error', 'Wystąpił błąd :(');

        return $this->redirectToRoute('admin_categories');
    }

}
