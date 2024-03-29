<?php

namespace App\Controller;

use Amp\Http\Client\Request;
use App\Repository\BlogpostRepository;
use App\Repository\CategorieRepository;
use App\Repository\PeintureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
    public function index(Request $request,
                        PeintureRepository $peintureRepository,
                        BlogpostRepository $blogpostRepository,
                        CategorieRepository $categorieRepository
                        ): Response
    {
        // $hostname= $request ->getSchemeAndHttpHost();

        $urls= [];

        $urls[] = ['loc' => $this->generateUrl('home')];
        $urls[] = ['loc' => $this->generateUrl('realisations')];
        $urls[] = ['loc' => $this->generateUrl('actualites')];
        $urls[] = ['loc' => $this->generateUrl('portfolio')];
        $urls[] = ['loc' => $this->generateUrl('a_propos')];
        $urls[] = ['loc' => $this->generateUrl('contact')];

        foreach ($peintureRepository->findAll() as $peinture) {
            $urls[] = [
                'loc'     => $this->generateUrl('realisations_details', ['slug' => $peinture->getSlug()]),
                'lastmod' => $peinture->getCreatedAt()->format('Y-m-d')
            ];
        }

        foreach ($blogpostRepository->findAll() as $blogpost) {
            $urls[] = [
                'loc'     => $this->generateUrl('actualites_details', ['slug' => $blogpost->getSlug()]),
                'lastmod' => $blogpost->getCreatedAt()->format('Y-m-d')
            ];
        }

        foreach ($categorieRepository->findAll() as $categorie) {
            $urls[] = [
                'loc'     => $this->generateUrl('portfolio_categorie', ['slug' => $categorie->getSlug()]),
                'lastmod' => $blogpost->getCreatedAt()->format('Y-m-d')
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls'     => $urls,
                'hostname' => $hostname,
            ]),
            200
        );

        $response->headers->set('Content-type', 'text/xml');

        
        return $response;
    }
}

