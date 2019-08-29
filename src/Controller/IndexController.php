<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class IndexController extends AbstractController
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {

        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $userForm = $this->createForm(UserType::class, null, [
            'action' => $this->generateUrl('registration')]);


        return $this->render('index/index.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request){

        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        $newPassword = $user->getPassword();
        $newPassword = $this->passwordEncoder->encodePassword($user , $newPassword);
        $user->setPassword($newPassword);

        if($userForm->isSubmitted() && $userForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success','Account created!');

            return $this->redirectToRoute('index');
        }
        return $this->render('index/index.html.twig', [
            'userForm' => $userForm->createView(),
        ]);

    }
}
