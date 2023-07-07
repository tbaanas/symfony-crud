<?php

namespace App\Service;

use App\Dto\ArticlesDto;
use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use DateTimeImmutable;

class ArticleService
{

    public function __construct(public ArticlesRepository $repository){

    }



    public function createArticle(ArticlesDto $dto){


        $article = new Articles();

        $article->setCreatedAt(new DateTimeImmutable());
      // może jakaś weryfikacja czy cos?
   // TODO zamiana DTO na ARTICLE

$this->repository->save($article);
    }

}