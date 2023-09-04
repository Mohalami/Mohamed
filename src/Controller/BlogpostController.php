<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Repository\BlogpostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogpostController extends AbstractController
{

    public function index(BlogpostRepository $blogpostRepository): Response
    {
        return $this->render('admin_blogpost/index.html.twig', [
            'blogposts' => $blogpostRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/actualites', name: 'actualites')]
    public function actualites(BlogpostRepository $blogpostRepository,
                               PaginatorInterface $paginator,
                               Request $request): Response
    {

        return $this->render('admin_blogpost/index.html.twig', [
            'blogposts' => $blogpostRepository->findAll(),
        ]);
        // $data= $blogpostRepository->findAll();

        // $blogposts= $paginator->paginate(
        //     $data,
        //     $request->query->getInt('page', 1),
        //     6
        // );
        // return $this->render('blogpost/actualites.html.twig', [
        //     'blogposts' => $blogposts,
        // ]);
    }

   
#[Route('/actualites/{slug}', name: 'actualites_detail')]
public function detail(string $slug, BlogpostRepository $blogpostRepository): Response
{
    $blogpost = $blogpostRepository->findOneBy(['slug' => $slug]);

    if (!$blogpost) {
        throw $this->createNotFoundException('Article non trouvé');
    }

    return $this->render('blogpost/detail.html.twig',[
        'blogpost' => $blogpost,
    ]);
}
   
}
