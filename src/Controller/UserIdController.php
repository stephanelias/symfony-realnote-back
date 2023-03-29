<?php

namespace App\Controller ;


use App\Entity\User;
use App\Repository\UserRepository;
use http\Client\Request;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class UserIdController extends AbstractController
{

    public TokenStorageInterface $storage ;
    public UserRepository $userRepository ;

    public function __construct(UserRepository $userRepository, TokenStorageInterface $storage)
    {
        $this->userRepository = $userRepository ;
        $this->storage = $storage ;
    }

    public function __invoke($data)
    {
        return $this->storage->getToken();
    }
}