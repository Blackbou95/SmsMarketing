<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i < 10 ;$i++)
           {
             $ctc = new Contact();
             $ctc->setNom("Anne".$i);
             $ctc->setPrenom("Ibrahima".$i);
             $ctc->setPhonenumber("777564104".$i);
             $manager->persist($ctc);
           }

        $manager->flush();
    }
}
