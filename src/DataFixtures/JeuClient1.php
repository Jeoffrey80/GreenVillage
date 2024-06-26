<?php
namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JeuClient1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      $client = new Client();
      $client->setNom("Locquet");
      $client->setPrenom("Enzo");
      $client->setRole("Perd son Paramètrage");
      $client->setAdresseLivraison("2 rue du FEURMEC");
      $client->setAdresseFacuration("69 rue du Theo");
      $client->setAdresseMail("enzoledozo@toto.com");
      $client->setPassword("lol1234");
      $client->setCoefficient("56.23");
      $client->setTypeclient("2");
      $client->setReductionProfessionnelle("40.36");  
      $manager->persist($client);
      $manager->flush();
    }
}
?>