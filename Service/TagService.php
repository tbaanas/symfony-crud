<?php

namespace App\Service;

use App\Repository\TagRepository;

class TagService
{
    public function __construct(public TagRepository $repository)
    {
    }

    public function getOneTag(int $getId): array
    {
        return $this->repository->findBy(['id' => $getId]);
    }
}
