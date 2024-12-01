<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event)
    {

        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $data['email'] = $user->getUserIdentifier(); 
        $data['roles'] = $user->getRoles();

        if ($user instanceof User) {
            $data['id'] = $user->getId();
            $data['firstName'] = $user->getFirstname(); 
            $data['lastName'] = $user->getLastname();    
        }

        $event->setData($data);
    }
}
