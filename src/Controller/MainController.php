<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * @Route("/main", methods={"GET"})
     */
    public function main()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/main/vue", methods={"GET"})
     */
    public function mainVue()
    {
        return $this->render('vue/index.html.twig');
    }
}