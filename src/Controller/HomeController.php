<?php
/**
 * Created by PhpStorm.
 * User: cpuga
 * Date: 2019-01-23
 * Time: 17:56
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage() {
        return $this->render('home/home.html.twig');
    }
}