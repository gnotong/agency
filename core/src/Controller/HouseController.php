<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\House;
use App\Entity\HouseSearch;
use App\Form\ContactType;
use App\Form\HouseSearchType;
use App\Message\SendNotification;
use App\Repository\HouseRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class HouseController extends AbstractController
{
    /**
     * @Route("/houses/{page<\d+>?1}", name="house_index")
     */
    public function index(Request $request, Paginator $paginator, HouseRepository $repository, int $page): Response
    {
        $houseSearch = new HouseSearch();
        $searchForm  = $this->createForm(HouseSearchType::class, $houseSearch);
        $searchForm->handleRequest($request);

        $paginator
            ->setCurrentPage($page)
            ->setQuery($repository->findByHouseSearch($houseSearch));

        return $this->render('house/index.html.twig', [
            'search_form' => $searchForm->createView(),
            'paginator'   => $paginator,
        ]);
    }

    /**
     * @Route("/houses/{slug}/show", name="houses_show")
     * @return Response
     */
    public function show(House $house, Request $request, MessageBusInterface $bus): Response
    {
        $contact = new Contact();
        $contact->setHouseName($house->getTitle());
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $bus->dispatch(new SendNotification($contact));

            $this->addFlash('success', 'Your message has been successfully sent !');
            return $this->redirectToRoute('houses_show', ['slug' => $house->getSlug()]);
        }

        return $this->render('house/show.html.twig', [
            'house' => $house,
            'form'  => $contactForm->createView(),
        ]);
    }
}
