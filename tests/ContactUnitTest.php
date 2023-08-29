<?php

namespace App\Tests;

use App\Entity\Contact;
use DateTime;
use PHPUnit\Framework\TestCase;

class ContactUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $contact= new Contact();
        $date= new DateTime();

        $contact->setNom('nom')
                ->setEmail('test@test.com')
                ->setMessage('message')
                ->setCreatedAt($date)
                ->setIsSend(true);

            $this->assertTrue($contact->getNom() === 'nom');
            $this->assertTrue($contact->getEmail() === 'test@test.com');
            $this->assertTrue($contact->getMessage() === 'message');
            $this->assertTrue($contact->getCreatedAt() === $date);
            $this->assertTrue($contact->getisSend() === true);
    }

    public function testIsFalse()
    {
        $contact= new Contact();
        $date= new DateTime();

        $contact->setNom('nom')
                ->setEmail('test@test.com')
                ->setMessage('message')
                ->setCreatedAt($date)
                ->setIsSend(true);

            $this->assertFalse($contact->getNom() === 'false');
            $this->assertFalse($contact->getEmail() === 'false@test.com');
            $this->assertFalse($contact->getMessage() === 'false');
            $this->assertFalse($contact->getCreatedAt() === new DateTime());
            $this->assertFalse($contact->getisSend() === false);
    }

    public function testIsEmpty()
    {
        $contact= new Contact();


            $this->assertEmpty($contact->getNom());
            $this->assertEmpty($contact->getEmail());
            $this->assertEmpty($contact->getMessage());
            $this->assertEmpty($contact->getCreatedAt());
            $this->assertEmpty($contact->getisSend());
            $this->assertEmpty($contact->getId());

    }
}
