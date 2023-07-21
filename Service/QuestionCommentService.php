<?php

namespace App\Service;

use App\Entity\Question;
use App\Entity\QuestionComment;
use App\Entity\User;
use App\Repository\QuestionCommentRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class QuestionCommentService
{
    public function __construct(public Questionrepository $questionRepository,
        public QuestionCommentRepository $questionCommentRepository, public RequestStack $requestStack)
    {
    }

   

    public function addCommentToQuestion(string $comment, User $user, Question $question): void
    {
        $comment = $this->addComment($comment, $user, $question);

        $this->questionCommentRepository->save($comment);
    }

    public function addCommentToCommentQuestion(string $comment, User $user, Question $question, QuestionComment $questionCommentParent): void
    {
        $comment = $this->addComment($comment, $user, $question);
        $comment->setParentComment($questionCommentParent);

        $this->questionCommentRepository->save($comment);
    }

    private function addComment(string $comment, User $user, Question $question): QuestionComment
    {
        
        $comment = new QuestionComment();
        $comment->setContent($comment);
        $comment->setUser($user);
        $comment->setAddDate(new \DateTime());
        $comment->setQuestion($question);
        $comment->setIp($this->getIpAddress());

        return $comment;
    }

    private function getIpAddress(): ?string
    {
        return $this->requestStack->getCurrentRequest()->getClientIp();
    }
}
