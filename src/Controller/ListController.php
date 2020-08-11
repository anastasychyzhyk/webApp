<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ListForm;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ListController extends AbstractController
{	 
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/list", name="list")
     */
    public function index(Request $request)
    {	
        $form = $this->createForm(ListForm::class);
        $form->handleRequest($request);
       	if ($form->isSubmitted() && !empty($_POST['checkbox']) && $this->processRequest($request)) {
			return $this->redirectToRoute('app_login');										 
		}
		else {
			return $this->render('list/index.html.twig', ['form' => $form->createView(), 'users' => $this->userRepository->findAll(),]);
		}
    }
	
	public function processRequest(Request $request)
	{		
		$needRedirectToLogin=false;
		foreach($_POST['checkbox'] as $email) {
		    $this->checkRequestTypeAndDo($email);
            $needRedirectToLogin = $needRedirectToLogin || $this->checkAndLogout($request, $email);
		}				
		return $needRedirectToLogin;
	}
	
	public function checkRequestTypeAndDo(string $email)
	{		
		$user = $this->userRepository->findOneBy(['email' => $email]);		
		if(isset($_POST['unblock'])) $this->userRepository->unblockUser($user);				
		else if(isset($_POST['delete'])) $this->userRepository->deleteUser($user);
		else if(isset($_POST['block'])) $this->userRepository->blockUser($user); 					
	}
	
	public function checkAndLogout(Request $request, string $email)
	{		
	    if(!isset($_POST['unblock']) && ($email==$request->getSession()->get(Security::LAST_USERNAME, ''))) {
			$this->container->get('security.token_storage')->setToken(null);
			    $this->get('session.handler.pdo.custom')->destroy($sessionId, $this->getUser()->getId());
   
 
            return true;			
		}
		else return false;
	}	
}
