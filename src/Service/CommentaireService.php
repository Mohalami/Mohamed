<?php

namespace App\Service;

use App\Entity\Blogpost;
use App\Entity\Commentaire;
use App\Entity\Peinture;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CommentaireService
{
    private $manager;
    
    public function __construct(EntityManagerInterface $manager
    //  FlashBagInterface $flash
     )
    {
        $this->manager = $manager;
    }

    public function persistCommentaire(
        Commentaire $commentaire,
        Blogpost $blogpost = null,
        Peinture $peinture = null
    ): void {
        $commentaire->setIsPublished(false)
            ->setBlogpost($blogpost)
            ->setPeinture($peinture)
            ->setCreatedAt(new DateTime('now'));

        $this->manager->persist($commentaire);
        $this->manager->flush();
        // $this->flash->add('success', 'Votre commentaire est bien envoyé. Il sera publié après validation');
        // Vous n'avez plus besoin d'utiliser $this->flash ici
    }
}
