<?php

namespace App\Dto\Conversion;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;

class UserConversion
{
    public function __construct(public UserRepository $userRepository)
    {
    }

    public function userToDtoWithoutDetails(User $user): UserDto
    {
        $dto = new UserDto();

        $dto->setId($user->getId());
        $dto->setUsername($user->getUsername());
        $dto->setEmail($user->getEmail());
        $dto->setRoles($user->getRoles());

        return $dto;
    }

    public function dtoToUserWithoutDetails(UserDto $dto): User
    {
        return $this->userRepository->find($dto->getId());
    }

    public function usersToDtoWithoutDetails(array $users): array
    {
        $dtos = [];

        foreach ($users as $user) {
            $dto = new UserDto();
            $dto->setId($user->getId());
            $dto->setUsername($user->getUsername());
            $dto->setEmail($user->getEmail());
            $dto->setRoles($user->getRoles());

            $dtos[] = $dto;
        }

        return $dtos;
    }
}
