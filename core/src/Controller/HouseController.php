<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\House;
use App\Repository\HouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HouseController extends AbstractController
{
    /**
     * @Route("/houses", name="house_index")
     */
    public function index(HouseRepository $repository): Response
    {
        return $this->render('house/index.html.twig', [
            'houses' => $repository->findLatest(),
        ]);
    }

    /**
     * @Route("/houses/{slug}/show", name="houses_show")
     * @return Response
     */
    public function show(House $house): Response
    {
        return $this->render('house/show.html.twig', ['house' => $house]);
    }
}
