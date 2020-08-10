<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {           
			$this->createUser($user);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/index.html.twig', ['form' => $form->createView(),]);
    }
	
	public function createUser(User $user)
	{
		$user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()))->setRoles(['ROLE_USER']);
		$user->setActive()->setRegistrationDate(date("d.m.y"))->setLastLoginDate('');         
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();       
	}
}