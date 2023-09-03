<?php

namespace App\Controller\Admin\Peinture;

use App\Entity\Peinture;
use App\Entity\User;
use App\Form\PeintureType;
use App\Repository\PeintureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/peinture')]
class AdminPeintureController extends AbstractController
{
    #[Route('/', name: 'app_admin_peinture_index', methods: ['GET'])]
    public function index(PeintureRepository $peintureRepository): Response
    {
        return $this->render('admin_peinture/index.html.twig', [
            'peintures' => $peintureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_peinture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slug): Response
    {
        $peinture = new Peinture();

        // Pour inserer le user 
        $user = $this->getUser();

        $peinture->setUser($user);

        // Pour inserer la date
        $now = new \DateTime('now');

        $peinture->setCreatedAt($now);

        
        $form = $this->createForm(PeintureType::class, $peinture);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();
            // Pour inserer un slug
            $nom = $datas->getNom();
            $generatedSlug = $nom ? $slug->slug($nom)->lower() : ''; // Vérifiez si $nom est défini
            $peinture->setSlug($generatedSlug);
            // dd($datas->getNom());
            
            $entityManager->persist($peinture);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_peinture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_peinture/new.html.twig', [
            'peinture' => $peinture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_peinture_show', methods: ['GET'])]
    public function show(Peinture $peinture): Response
    {
        return $this->render('admin_peinture/show.html.twig', [
            'peinture' => $peinture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_peinture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Peinture $peinture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PeintureType::class, $peinture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_peinture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_peinture/edit.html.twig', [
            'peinture' => $peinture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_peinture_delete', methods: ['POST'])]
    public function delete(Request $request, Peinture $peinture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$peinture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($peinture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_peinture_index', [], Response::HTTP_SEE_OTHER);
    }
}
