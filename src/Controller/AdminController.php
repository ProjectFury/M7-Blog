<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserControlType;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/users", name="app_admin_users")
     */
    public function useradmin() {
        $users = $this -> getDoctrine() -> getRepository(User::class)->findAll();

        return $this->render("admin/userlist.html.twig", array(
            'users'=>$users,
        ));
    }

    /**
     * @Route("/admin/users/create",name="app_admin_users_create")
     */
    public function userCreate(Request $request, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        // Create the form
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        $error = $form->getErrors();

        $form2 = $this->createForm(UserControlType::class, $user);

        $form2->handleRequest($request);

        $error = $form2->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);

            // handle the entities
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'User created');

            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/usercreate.html.twig', [
            'form'  => $form->createView(),
            'form2'  => $form2->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/admin/users/{id}", name="app_admin_users_edit")
     */
    public function userEdit(User $id, Request $request, UserPasswordEncoderInterface $encoder) {
        $user = $id;
        // Create the form
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        $error = $form->getErrors();

        $form2 = $this->createForm(UserControlType::class, $user);

        $form2->handleRequest($request);

        $error = $form2->getErrors();


        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);

            // handle the entities
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'User modified');

            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/useredit.html.twig', [
            'form'  => $form->createView(),
            'form2'  => $form2->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/admin/users/{id}/delete", name="app_admin_users_delete")
     */
    public function userDelete(User $id) {
        $user = $id;
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', 'User deleted');

        return $this->redirectToRoute('app_admin_users');
    }
}
