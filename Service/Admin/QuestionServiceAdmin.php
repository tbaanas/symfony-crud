<?php

namespace App\Service\Admin;

use App\Entity\Question;
use App\Model\admin\AdminUsersService;
use App\Repository\QuestionRepository;
use App\Service\CategoryService;
use DateTime;
use PHPUnit\Util\Exception;

class QuestionServiceAdmin
{
    private QuestionRepository $questionRepository;
    private CategoryService $categoryService;
    private AdminUsersService $usersService;

    public function __construct(QuestionRepository $questionRepository, CategoryService $categoryService, AdminUsersService $usersService)
    {
        $this->questionRepository = $questionRepository;
        $this->categoryService = $categoryService;
        $this->usersService = $usersService;
    }


    /*
   * Get All question to accept from DB to Twig List
   */
    public function getAllCategoriesNotAccept(): array
    {
        return $this->questionRepository->findBy(['accept' => false]);
    }

    public function saveQuestion(Question $getData, string $username): bool
    {
        if ($getData->getid() != null) {
            return $this->updateQuestion($getData);
        }
        try {

            $user = $this->usersService->findOneByUsername($username);
            $getData->setCreatedDate(new DateTime());
            $getData->setUser($user);
            $getData->setCategory($this->categoryService->getOneCategoryByName($getData->getCategory()->getName()));

        } catch (Exception $e) {
            return false;
        }

        // $getData->setUser();
        $this->questionRepository->save($getData, true);
        return true;
    }


    public function updateQuestion(Question $getData): bool
    {
        $question = $this->questionRepository->findOneBy(['id' => $getData->getId()]);

        try {

            $question->setTitle($getData->getTitle());
            $question->setContent($getData->getContent());
            $question->setCategory($getData->getCategory());

        } catch (Exception $e) {
            return false;
        }

        // $getData->setUser();
        $this->questionRepository->save($question, true);
        return true;
    }


    public function acceptQuestion(int $id): bool
    {
        $question = $this->questionRepository->findOneBy(['id' => $id]);
        if ($question != null) {
            $question->setAccept(true);

            $this->questionRepository->save($question, true);
            return true;
        }
        return false;
    }

    public function deleteQuestion(int $id): bool
    {
        $question = $this->questionRepository->findOneBy(['id' => $id]);
        if ($question != null) {

            $this->questionRepository->remove($question, true);
            return true;
        }
        return false;
    }

    public function getAllCategoriesAreAccept(): array
    {
        return $this->questionRepository->findBy(['accept' => true]);
    }

    public function moderateQuestion(int $id): bool
    {
        $question = $this->questionRepository->findOneBy(['id' => $id]);
        if ($question != null) {
            $question->setAccept(false);

            $this->questionRepository->save($question, true);
            return true;
        }
        return false;
    }

    public function getQuestion(int $id): ?Question
    {
        return $this->questionRepository->findOneBy(['id' => $id]);
    }


}