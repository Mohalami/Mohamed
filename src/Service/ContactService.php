<?php

namespace App\Service;

use App\Entity\Contact;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContactService
{
    private $manager;
    private $session;

    public function __construct(EntityManagerInterface $manager, SessionInterface $session)
    {
        $this->manager = $manager;
        $this->session = $session;
    }

    public function persistContact(Contact $contact): void
    {
        $contact->setIsSend(false)
            ->setCreatedAt(new DateTime('now'));

        $this->manager->persist($contact);
        $this->manager->flush();

        $this->session->getFlashBag()->add('success', 'Votre message est bien envoyé, merci.');
    }


    public function isSend(Contact $contact):void
    {
        $contact->setIsSend(true);

        $this->manager->persist($contact);
        $this->manager->flush();
    }
}