<?php

namespace App\DataFixtures;

use App\Entity\Blogpost;
use App\Entity\Categorie;
use App\Entity\Peinture;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Utilisation de faker
        $faker= Factory::create('fr_FR');

        // Creation d'un utlisateur
        $user= new User();

        $user->setEmail(('user@test.com'))
             ->setPrenom($faker->firstName())
             ->setNom($faker->lastName())
             ->setTelephone($faker->phoneNumber())
             ->setAPropos($faker->text())
             ->setInstagram('instagram');

             $password = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($password);
        $manager->persist($user);

        // Creation de 10 blogpost
        for ($i=0; $i < 10; $i++) { 
            $blogpost= new Blogpost();

            $blogpost->setTitre($faker->words(3, true))
                     ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                     ->setContenu($faker->text(350))
                     ->setSlug($faker->slug(3))
                     ->setUser($user);
            $manager->persist($blogpost);
        }

        // Creation de categorie
        for ($k=0; $k < 5 ; $k++) { 
           $categorie= new Categorie();

           $categorie->setNom($faker->words(3, true))
                     ->setDescription($faker->words(10, true))
                     ->setSlug($faker->slug());

                     $manager->persist($categorie);

                    //  Creation de 2 peintures
                    for ($j=0; $j < 2; $j++) { 
                        $peinture= new Peinture();

                        $peinture->setNom($faker->words(3, true))
                                 ->setLargeur($faker->randomFloat(2, 20, 60))
                                 ->setHauteur($faker->randomFloat(2, 20, 60))
                                 ->setEnVente($faker->randomElement([true, false]))
                                 ->setDateRealisation($faker->dateTimeBetween('-6 monyh', 'now'))
                                 ->setCreatedAt($faker->dateTimeBetween('-6 monyh', 'now'))
                                 ->setDescription($faker->text())
                                 ->setPorteFolio($faker->randomElement([true, false]))
                                 ->setSlug($faker->slug())
                                 ->setFile('/img/exemple.jpg')
                                 ->addCategorie($categorie)
                                 ->setPrix($faker->randomFloat(2, 100, 9999 ))
                                 ->setUser($user);

                        $manager->persist($peinture);
                
                                 
                    }
        }
        $manager->flush();
    }
}
