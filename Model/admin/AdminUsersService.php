<?php

namespace App\Model\admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminUsersService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // getAllUsersNotDeleteAndBlocked -pobiera wszystkich userów z bazy, którzy nie są usunięci i zablokowani

    public function getAllUsersNotDeleteAndBlocked(): array
    {
        return $this->userRepository->findAllWhoAreNotBlockAndDelete();
    }

    // findOneByAllDetailsId -usera po ID wraz z UserDetails
    public function findOneByAllDetailsId(int $id): array
    {
        $userDetails = $this->userRepository->findOneByAllDetailsId($id);
        if (null === $userDetails) {
            throw new NotFoundHttpException('User not found.', null, 404);
        }

        return $userDetails;
    }

    // delete user, check is admin.
    public function delete(int $id, bool $isAdmin): bool
    {
        $userToDelete = $this->userRepository->find($id);

        if (null === $userToDelete) {
            throw new NotFoundHttpException('User not exist.', null, 404);
        }
        if ($isAdmin && null != $userToDelete) {
            $this->userRepository->remove($userToDelete, true);

            return true;
        }

        return false;

     
    }

    public function findOneByUsername(string $username): User
    {
        $tempUser = $this->userRepository->findOneBy(['username' => $username]);
        if (null === $tempUser) {
            throw new NotFoundHttpException('User not exist.', null, 404);
        }

        return $tempUser;
    }

    public function update(User $user): bool
    {
        //  if($user->getRoles()!=null){
        //     $this->userRepository->update($user,true);
        //  }
        $this->userRepository->save($user, true);

        return true;
    }

    public function saveLoginHistory(string $user)
    {
    }

    public function findOneById($userId): ?User
    {
        return $this->userRepository->findOneBy(['id' => $userId]);
    }

    public function banBlockUser(int $id, string|null $get): bool
    {
        try {
            $user = $this->userRepository->findOneBy(['id' => $id]);
            $user->setBanReason($get);
            $user->setBanned(true);
            $user->setBanDate(new \DateTime());
            $this->userRepository->update($user, true);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function getAllRemovedUsers(): array
    {
        return $this->userRepository->findAllWhoAreRemoved();
    }

    public function getOneUser(int $getId): ?User
    {
        return $this->userRepository->findOneBy(['id' => $getId]);
    }

    public function getAllUsersBanned(): array
    {
        return $this->userRepository->findAllWhoAreBanned();
    }
}
