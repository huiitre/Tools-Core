<?php

namespace App\EventListener;

use App\Entity\Core\User\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    /**
     * Permet d'envoyer des informations à l'authentification d'un utilisateur
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        $userEnt = $event->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }
        if (!$userEnt instanceof User) {
            return;
        }

        $data['data'] = array(
            'email' => $user->getUserIdentifier(),
            'nickname'  => $user->getNickname(),
            'type' => $user->getType()
        );

        $event->setData($data);
    }
}
