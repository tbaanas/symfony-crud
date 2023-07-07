<?php

namespace App\Service;

use App\Dto\Conversion\QuestionConversion;
use App\Dto\QuestionDto;
use App\Entity\Question;
use App\Entity\Tag;
use App\Model\admin\AdminUsersService;
use App\Repository\QuestionRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\isNull;

class QuestionService
{




    public function __construct(public TagService $tagService,public QuestionConversion $converter,public QuestionRepository $questionRepository, public CategoryService $categoryService)
    {

    }

    public function getOneQuestion(int $id): QuestionDto
    {

        $question=$this->questionRepository->findBy(["id"=>$id]);
        return $this->questionToDto($question);

    }

    public function getNewQuestionsMainPage(Request $request): Paginator
    {
        $entityManager = $this->getDoctrine()->getManager();
        $questionRepository = $entityManager->getRepository(Question::class);

        $query = $questionRepository->createQueryBuilder('q')
            ->getQuery();

        $paginator = new Paginator($query);

        // Ustaw liczbę wyników na stronę
        $paginator->getQuery()
            ->setFirstResult($request->query->getInt('page', 1) - 1)
            ->setMaxResults(20); // liczba pytań na stronę

return $paginator;
    }


    public function questionToDto(Question $question): QuestionDto
    {
        $questionDto = new QuestionDto();
        $questionDto->setId($question->getId());
        $questionDto->setUser($question->getUser()->getUsername());
        $questionDto->setContent($question->getContent());
        $questionDto->setTitle($question->getTitle());
        $questionDto->setCreatedDate($question->getCreatedDate());
        $questionDto->setCategory($question->getCategory()->getName());
        $questionDto->setQuestionComments($question->getQuestionComments());
        $questionDto->setTags($question->getTags());
        $questionDto->setVotesMinus($question->getVotesMinus());
        $questionDto->setVotesPlus($question->getVotesPlus());


        return $questionDto;

    }





    public function dtoToQuestion(QuestionDto $questionDto): Question
    {
        $question=$this->questionService->getOneQuestion($questionDto->getId());
        if(!isNull($question)){
            $question=new Question();
            $question->setUser($this->userService->getOneUser($questionDto->getId()));
            $question->setCreatedDate(new DateTime());
        }
        $question->setContent($questionDto->getContent());
        $question->setTitle($questionDto->getTitle());

        $question->setCategory($this->categoryService->getOneCategoryByName($questionDto->getCategory()));
        // Dodaj wszystkie tagi do pytania
        foreach ($questionDto->getTags() as $tagDto) {
            //TODO
            $tag = $this->tagService->getOneTag($tagDto->getId());

            if (!isNull($tag)) {
                // Jeśli tag już istnieje, dodaj go do pytania
                $question->addTag($tag);
            } else {
                // Jeśli tag nie istnieje, utwórz nowy tag i dodaj go do pytania
                $newTag = new Tag();
                $newTag->setName($tagDto->getName());
                $question->addTag($newTag);
            }
        }



        return $question;

    }


}