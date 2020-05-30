<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\House;
use App\Repository\HouseRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HouseController extends AbstractController
{
    /**
     * @Route("/houses/{page<\d+>?1}", name="house_index")
     */
    public function index(HouseRepository $repository, Paginator $paginator, int $page): Response
    {
        $paginator
            ->setEntityClass(House::class)
            ->setCurrentPage($page)
            ->setCriteria(['sold' => false]);

        return $this->render('house/index.html.twig', [
            'paginator' => $paginator,
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
