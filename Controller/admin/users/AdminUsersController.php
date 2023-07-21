<?php

namespace App\Controller\admin\users;

use App\Form\UserEditFormType;
use App\Model\admin\AdminUsersService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminUsersController extends AbstractController
{
    private AdminUsersService $usersService;

    public function __construct(AdminUsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    #[Route('/admin/users', name: 'app_admin_users')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/users/allUsers.html.twig', [
            'users' => $this->usersService->getAllUsersNotDeleteAndBlocked(),
        ]);
    }

    #[Route('/admin/users/removed', name: 'app_admin_removedUsers')]
    #[IsGranted('ROLE_ADMIN')]
    public function removedUsers(): Response
    {
        return $this->render('admin/users/allBannedUsers.html.twig', [
            'users' => $this->usersService->getAllRemovedUsers(),
        ]);
    }

    #[Route('/admin/users/{id}', name: 'app_admin_userDetails', methods: ['GET']) ]
    #[IsGranted('ROLE_ADMIN')]
    public function userDetails(int $id): Response
    {
        return $this->render('admin/users/userDetails.html.twig', [
            'user' => $this->usersService->findOneByAllDetailsId($id),
        ]);
    }

    #[Route('/admin/users/{id}/delete', name: 'admin_userDelete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function userDelete(int $id, Security $security): Response
    {
        $status = $this->usersService->delete($id, $security->isGranted('ROLE_ADMIN'));

        if ($status) {
            $this->addFlash('success', 'Użytkownik został usunięty.');
        } else {
            $this->addFlash('error', 'Wystąpił błąd :(');
        }

        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/admin/users/ban', name: 'admin_userBan', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function userBan(Request $request): Response
    {
        $status = $this->usersService->banBlockUser($request->request->get('utbi'), $request->request->get('ban_reason'));

        if ($status) {
            $this->addFlash('success', 'Użytkownik został Zablokowany.');
        } else {
            $this->addFlash('error', 'Wystąpił błąd :(');
        }

        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/admin/users/banned', name: 'admin_userBanned')]
    #[IsGranted('ROLE_ADMIN')]
    public function userBanned(Request $request): Response
    {
        return $this->render('admin/users/allUsers.html.twig', [
            'users' => $this->usersService->getAllUsersBanned(),
        ]);
    }

    #[Route('/admin/users/{username}/edit', name: 'admin_userEdit', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function editUserData(string $username): Response
    {
        $user = $this->usersService->findOneByUsername($username);
        $form = $this->createForm(UserEditFormType::class);
        $form->setData($user);

        return $this->render('admin/users/userEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/users/{username}/edit', name: 'app_admin_userEdit', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function editUserDataToDb(Request $request, string $username): Response
    {
        $user = $this->usersService->findOneByUsername($username);
        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->usersService->update($form->getData());
            $this->addFlash('success', 'Użytkownik został usunięty.');

            return $this->redirectToRoute('app_admin_users');
        }
        $this->addFlash('error', 'Wystąpił błąd :(');
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                echo $error->getMessage().'<br>';
                var_dump($error->getMessage());
            }
        }

        return $this->redirectToRoute('app_admin_users');
    }
}
