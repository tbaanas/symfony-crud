<?php

namespace App\Controller\admin\question;

use App\Form\QuestionCreateFormType;
use App\Service\Admin\QuestionServiceAdmin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminQuestionController extends AbstractController
{
    private QuestionServiceAdmin $questionService;

    public function __construct(QuestionServiceAdmin $questionService)
    {
        $this->questionService = $questionService;
    }

    // Question do akceptu
    #[Route('/admin/question', name: 'admin_question_list')]
    public function index(): Response
    {
        return $this->render('admin/question/index.html.twig', [
            'questions' => $this->questionService->getAllCategoriesNotAccept(),
        ]);
    }

    #[Route('/admin/question/accepted', name: 'admin_question_list_accept')]
    public function acceptedQuestion(): Response
    {
        return $this->render('admin/question/index.html.twig', [
            'questions' => $this->questionService->getAllCategoriesAreAccept(),
        ]);
    }

    #[Route('/admin/question/add', name: 'admin_question_add', methods: ['GET'])]
    public function addQuestion(): Response
    {
        $form = $this->createForm(QuestionCreateFormType::class);

        return $this->render('admin/question/addQuestion.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/question/{id}/edit', name: 'admin_question_edit', methods: ['GET'])]
    public function editQuestion(int $id): Response
    {
        $question = $this->questionService->getQuestion($id);
        $form = $this->createForm(QuestionCreateFormType::class, $question);

        return $this->render('admin/question/addQuestion.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/question/{id}/accept', name: 'admin_question_accept', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function acceptQuestion(int $id): Response
    {
        $status = $this->questionService->acceptQuestion($id);
        if ($status) {
            $this->addFlash('success', 'Pytanie zostało zatwierdzone.');

            return $this->redirectToRoute('admin_question_list');
        }
        $this->addFlash('error', 'Wystąpił błąd.');

        return $this->redirectToRoute('admin_question_list');
    }

    #[Route('/admin/question/{id}/delete', name: 'admin_question_delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteQuestion(int $id): Response
    {
        $status = $this->questionService->deleteQuestion($id);
        if ($status) {
            $this->addFlash('success', 'Pytanie zostało usunięte.');

            return $this->redirectToRoute('admin_question_list');
        }
        $this->addFlash('error', 'Wystąpił błąd.');

        return $this->redirectToRoute('admin_question_list');
    }

    #[Route('/admin/question/{id}/moderate', name: 'admin_question_to_moderate', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function moderateQuestion(int $id): Response
    {
        $status = $this->questionService->moderateQuestion($id);
        if ($status) {
            $this->addFlash('success', 'Pytanie zostało przeniesione.');

            return $this->redirectToRoute('admin_question_list');
        }
        $this->addFlash('error', 'Wystąpił błąd.');

        return $this->redirectToRoute('admin_question_list');
    }

    #[Route('/admin/question/save', name: 'admin_question_save_new', methods: ['POST'])]
    public function saveQuestion(Request $request, Security $security): Response
    {
        $user = $security->getUser();

        $form = $this->createForm(QuestionCreateFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->questionService->saveQuestion($form->getData(), $user->getUserIdentifier());
            $this->addFlash('success', 'Pytanie zostało dodane!.');

            return $this->redirectToRoute('admin_question_list');
        }
        $this->addFlash('error', 'Wystąpił błąd :(');
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                echo $error->getMessage().'<br>';
                // var_dump($error->getMessage());
            }
        }

        return $this->redirectToRoute('admin_question_list');
    }

    #[Route('/admin/question/update', name: 'admin_question_update', methods: ['POST'])]
    public function updateQuestion(Request $request, Security $security): Response
    {
        $form = $this->createForm(QuestionCreateFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->questionService->updateQuestion($form->getData());
            $this->addFlash('success', 'Pytanie zostało zaktualizowane!.');

            return $this->redirectToRoute('admin_question_list');
        }
        $this->addFlash('error', 'Wystąpił błąd :(');
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                echo $error->getMessage().'<br>';
                // var_dump($error->getMessage());
            }
        }

        return $this->redirectToRoute('admin_question_list');
    }
}
