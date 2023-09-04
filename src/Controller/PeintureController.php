<?php

namespace App\Controller;

use App\Entity\Peinture;
use App\Repository\PeintureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;


class PeintureController extends AbstractController
{   
    #[Route('/realisations', name: 'realisations')]
    public function realisations(PeintureRepository $peintureRepository
    //  CacheManager $cacheManager
     ): Response
    {
        $peintures = $peintureRepository->findBy([], ['id' => 'DESC']);

        // Utilisation de CacheManager
        // $resolvedPath = $cacheManager->getBrowserPath('/uploads/peintures/' . $peinture->getImageFile(), 'my_thumb');
    
        return $this->render('peinture/realisations.html.twig', [
            'peintures' => $peintures,
            // 'resolvedPath' => $resolvedPath,
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
