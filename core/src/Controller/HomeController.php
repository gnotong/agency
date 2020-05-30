<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\HouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(HouseRepository $repository)
    {
        return $this->render('home/index.html.twig', [
            'houses' => $repository->findLatest(),
        ]);
    }
}
