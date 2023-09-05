<?php

namespace App\Controller;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\BlogpostRepository;
use App\Repository\CommentaireRepository;
use App\Service\CommentaireService;
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
    public function actualites(BlogpostRepository $blogpostRepository): Response
    {

        return $this->render('blogpost/actualites.html.twig', [
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
public function detail(Blogpost $blogpost,
                        Request $request,
                        CommentaireService $commentaireService,
                        CommentaireRepository $commentaireRepository
): Response
{

    $commentaires= $commentaireRepository->findCommentaires($blogpost);
    $commentaire = new Commentaire();
    $form= $this->createForm(CommentaireType::class, $commentaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $commentaire = $form->getData();
        $commentaireService->persistCommentaire($commentaire, $blogpost, null);

        return $this->redirectToRoute('actualites_detail', ['slug' => $blogpost->getSlug()]);
    }


    return $this->render('blogpost/detail.html.twig',[
        'blogpost' => $blogpost,
        'form' => $form->createView(),
        'commentaires' => $commentaires,
    ]);
}
   
}
