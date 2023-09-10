<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use APP\Service\ContactService;
use Doctrine\ORM\EntityManagerInterface;
USE Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommand extends Command
{
    private $entityManagerInterface;
    private UserPasswordHasherInterface $hasher;
    protected static $defaultName= 'app:create-user';

    public function __construct(
        EntityManagerInterface $entityManagerInterface,
        UserPasswordHasherInterface $hasher
    )
    {
        $this->entityManagerInterface= $entityManagerInterface;
        $this-> hasher= $hasher;
        parent::__construct();
    }

    protected function configure():void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
             ->addArgument('password', InputArgument::REQUIRED, 'The paassword of the user.')
       ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user= new User();

        $user->setEmail($input->getArgument('username'));

        $password = $this->hasher->hashPassword($user, $input->getArgument('password'));
        $user->setPassword($password);

        $user->setRoles(['ROLE_PEINTRE'])
             ->setPrenom('')
             ->setNom('')
             ->setTelephone(''); 

            //  dump($user);

        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        return Command::SUCCESS;
    }

 
}