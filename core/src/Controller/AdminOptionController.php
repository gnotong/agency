<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/options")
 */
class AdminOptionController extends AbstractController
{
    /**
     * @Route("/", name="admin_options_index", methods={"GET"})
     */
    public function index(OptionRepository $optionRepository): Response
    {
        return $this->render('admin/option/index.html.twig', [
            'options' => $optionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_options_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($option);
            $manager->flush();

            return $this->redirectToRoute('admin_options_index');
        }

        return $this->render('admin/option/new.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_options_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Option $option, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('admin_options_index');
        }

        return $this->render('admin/option/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_options_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Option $option, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$option->getId(), $request->request->get('_token'))) {
            $manager->remove($option);
            $manager->flush();
        }

        return $this->redirectToRoute('admin_options_index');
    }
}
