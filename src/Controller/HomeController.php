<?php

namespace App\Controller;

use App\Entity\Collaborator;
use App\Entity\Partner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/', name: 'app_home')]
class HomeController extends AbstractController
{
    public function __invoke(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        //$collaborator = new Collaborator();
        //$partner = new Partner();

//        $collaborator
//            ->setEmail('collaborator@test.com')
//            ->setPassword($passwordHasher->hashPassword($collaborator, 'password'))
//            ->setFirstname('john')
//            ->setLastname('doe');

//        $partner
//            ->setEmail('partner@test.com')
//            ->setPassword($passwordHasher->hashPassword($partner, 'demo'))
//            ->setFirstname('john')
//            ->setLastname('doe');

        //$em->persist($collaborator);
        //$em->persist($partner);
        //$em->flush();


        return $this->render('home/home.html.twig');
    }
}