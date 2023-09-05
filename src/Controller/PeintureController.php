<?php

namespace App\Controller;


use App\Entity\Commentaire;
use App\Entity\Peinture;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\PeintureRepository;
use App\Service\CommentaireService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



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
    public function details(Peinture $peinture,
                            Request $request,
                            CommentaireService $commentaireService,
                            CommentaireRepository $commentaireRepository
    ): Response
    {   
        $commentaires = $commentaireRepository->findCommentaires($peinture);
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form ->getData();
            $commentaireService->persistCommentaire($commentaire, null, $peinture);

            return $this->redirectToRoute('realisations_details', ['slug' => $peinture->getSlug()]);
        }
        
        
        if(!$peinture){
            throw $this->createNotFoundException('Peinture non trouvée');
        }
        return $this->render('peinture/details.html.twig', [
            'peinture' =>$peinture,
            'form' =>$form->createView(),
            'commentaires' => $commentaires,
        ]);
    }
}
