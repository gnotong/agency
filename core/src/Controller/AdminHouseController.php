<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\House;
use App\Form\HouseType;
use App\Repository\HouseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHouseController extends AbstractController
{
    /**
     * @Route("/admin/houses", name="admin_houses_index")
     */
    public function index(HouseRepository $repository)
    {
        return $this->render('admin/house/index.html.twig', [
            'houses' => $repository->findAllForSale(),
        ]);
    }

    /**
     * @Route("/admin/houses/new", name="admin_houses_new", methods={"POST", "GET"})
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $house = new House();
        $form = $this->createForm(HouseType::class, $house);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            foreach ($house->getAttachments() as $attachment) {
                $attachment->setHouse($house);
                $manager->persist($attachment);
            }
            $manager->persist($house);
            $manager->flush();
            $this->addFlash('success', 'Record successfully added');

            return $this->redirectToRoute('admin_houses_index');
        }

        return $this->render('admin/house/new.html.twig', [
           'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/houses/{id}/edit", name="admin_houses_edit", methods={"POST", "GET"})
     */
    public function edit(House $house, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(HouseType::class, $house);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($house->getAttachments() as $attachment) {
                $attachment->setHouse($house);
                $manager->persist($attachment);
            }
            $manager->flush();
            $this->addFlash('success', 'Record successfully updated');

            return $this->redirectToRoute('admin_houses_index');
        }

        return $this->render('admin/house/edit.html.twig', [
            'form' => $form->createView(),
            'house' => $house,
        ]);
    }

    /**
     * @Route("/admin/houses/{id}/delete", name="admin_houses_delete", methods={"DELETE"})
     */
    public function delete(House $house, EntityManagerInterface $manager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $house->getId(), $request->get('_token'))) {
            $manager->remove($house);
            $manager->flush();
            $this->addFlash('success', 'Record successfully deleted');
        }

        return $this->redirectToRoute("admin_houses_index");
    }
}
