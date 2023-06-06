<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/user", name="api_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile", methods={"GET"})
     *
     * @return Response
     */
    public function profile(): Response
    {
        $user = $this->getUser();

        $data = [
            'email' => $user->getEmail(),
            'name' => $user->getName()
        ];

        // dd('user : ', $user);

        return $this->json(
            $data,
            200,
            []
        );
    }
}