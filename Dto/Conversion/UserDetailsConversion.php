<?php

namespace App\Dto\Conversion;

use App\Dto\UserDetailsDto;
use App\Entity\UserDetails;
use App\Repository\UserDetailsRepository;

class UserDetailsConversion
{
    public function __construct(public UserDetailsRepository $detailsRepository)
    {
    }

    public function UserDetailsToDto(UserDetails $details): UserDetailsDto
    {
        $dto = new UserDetailsDto();

        $dto->setId($details->getId());
        $dto->setName($details->getName());
        $dto->setSurname($details->getSurname());
        $dto->setDescription($details->getDescription());

        return $dto;
    }

    public function dtoToUserDetails(UserDetailsDto $dto): UserDetails
    {
        return $this->detailsRepository->find($dto->getId());
    }
}
