<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\House;
use App\Entity\HouseSearch;
use App\Form\HouseSearchType;
use App\Repository\HouseRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HouseController extends AbstractController
{
    /**
     * @Route("/houses/{page<\d+>?1}", name="house_index")
     */
    public function index(Request $request, Paginator $paginator, HouseRepository $repository,int $page): Response
    {
        $houseSearch = new HouseSearch();
        $searchForm = $this->createForm(HouseSearchType::class, $houseSearch);
        $searchForm->handleRequest($request);

        $paginator
            ->setCurrentPage($page)
            ->setQuery($repository->findByHouseSearch($houseSearch));

        return $this->render('house/index.html.twig', [
            'search_form' => $searchForm->createView(),
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
