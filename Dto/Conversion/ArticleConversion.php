<?php

namespace App\Dto\Conversion;

use App\Dto\ArticlesDto;
use App\Entity\Articles;

class ArticleConversion
{
    public function articleToDto(Articles $articles): ArticlesDto
    {
        $dto = new ArticlesDto();

        return $dto;
    }

    public function dtoToArticle(ArticlesDto $dtoarticles): Articles
    {
        $article = null;

        return $article;
    }
}
