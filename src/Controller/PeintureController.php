<?php

namespace App\Controller;

use App\Entity\Peinture;
use App\Repository\PeintureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeintureController extends AbstractController
{   
    #[Route('/realisations', name: 'realisations')]
    public function realisations(PeintureRepository $peintureRepository): Response
    {
        $peintures = $peintureRepository->findBy([], ['id' => 'DESC']);
    
        return $this->render('peinture/realisations.html.twig', [
            'peintures' => $peintures,
        ]);
    }

    #[Route('/realisations/{slug}', name: 'realisations_details')]
    public function details(string $slug, PeintureRepository $peintureRepository): Response
    {   
        $peinture= $peintureRepository->findOneBy(['slug' =>$slug]);
        
        if(!$peinture){
            throw $this->createNotFoundException('Peinture non trouvée');
        }
        return $this->render('peinture/details.html.twig', [
            'peinture' =>$peinture,
        ]);
    }
}
