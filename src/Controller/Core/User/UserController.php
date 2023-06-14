<?php

namespace App\Controller\Core\User;

use App\Entity\Core\User\User;
use App\Repository\Core\User\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\MessageResponse;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user/profile", name="api_user_profile", methods={"GET"})
     *
     * @return Response
     */
    public function getProfile()
    {
        $user = $this->getUser();

        dd('$data : ');
    }

    /**
     * @Route("/user/register", name="user_register", methods={"POST"})
     *
     * @param Request $request
     * @param UserPasswordHasher $hasher
     * @return void
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
        SerializerInterface $serializer,
        MessageResponse $msg,
        UserRepository $userRepository
    )
    {
        $requestData = $request->getContent();

        try {
            $user = $serializer->deserialize($requestData, User::class, 'json');
        } catch(Exception $e) {
            return $this->json(
                ['msg' => 'Une erreur est survenue, veuillez contacter un administrateur', 'status' => -1],
                200, []
            );
        }

        $status = 1;

        //* vérification des champs obligatoires
        if (empty($user->getEmail())) {
            $msg->setMsg('Le champ email est obligatoire');
            $status = 0;
        }

        //todo vérification que l'email soit bien une vraie adresse email
        //todo ...

        if (empty($user->getNickname())) {
            $msg->setMsg('Le champ pseudo est obligatoire');
            $status = 0;
        }

        if (empty($user->getPassword())) {
            $msg->setMsg('Le champ mot de passe est obligatoire');
            $status = 0;
        }

        if ($status === 0)
            return new JsonResponse(['msg' => $msg->getMsg(), 'status' => $status], Response::HTTP_OK);
        
        //* est-ce qu'un utilisateur existe déjà avec cet email
        $existingUser = $userRepository->findUserBy(['email' => $user->getEmail()]);
        if ($existingUser != 0)
            return new JsonResponse(['msg' => ['Cette adresse email est déjà utilisée'], 'status' => 0]);

        //todo vérification que le mot de passe soit assez grand
        //todo ...
        //* hashage du mot de passe
        $user->setPassword($hasher->hashPassword($user, $user->getPassword()));

        //* ajout du rôle par défaut et compte désactivé également
        $user->setType(1);
        $user->setIs_active(0);

        //* ajout de l'utilisateur en base
            $response = $userRepository->createUser($user);
            
        if ($response === 1)
            return new JsonResponse(['msg' => 'Votre compte a été créé avec success. Il est maintenant en attente de validation.', 'status' => 1]);
        return new JsonResponse(['msg' => 'Erreur lors de la création du compte. Veuillez contacter un administrateur.', 'status' => -1]);
    }
}