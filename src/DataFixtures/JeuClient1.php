<?php
namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

 class JeuClient1 extends Fixture
 {
     public function load(ObjectManager $manager): void
    {
      $c1 = new Categorie();
      $c1->setNomCategorie("Guitares");
      $c1->setDescriptionCategorie("Guitare tout type");
      $c1->setImageCategorie("guitares.png");
      $c1->setTypeCategorie("Guitare01");
      $manager->persist($c1);

      $sc1 = new Categorie();
      $sc1->setNomCategorie("Guitares electriques");
      $sc1->setDescriptionCategorie("Guitare electrique tout type");
      $sc1->setImageCategorie("Guitares electriques.png");
      $sc1->setTypeCategorie("GuitareEle01");
      $manager->persist($sc1);

      //$c1->addSousCategory($sc1);
      $sc1->setParent($c1);

      $ssc1 = new Categorie();
      $ssc1->setNomCategorie("Piano à queue");
      $ssc1->setDescriptionCategorie("...");
      $ssc1->setImageCategorie("piano_queue1.png");
      $ssc1->setTypeCategorie("PianoQue01");
      $manager->persist($ssc1);

      $sc1->addSousCategory($ssc1);
      $ssc1->setParent($sc1);

      $c2 = new Categorie();
      $c2->setNomCategorie("Piano droit");
      $c2->setDescriptionCategorie(". . .");
      $c2->setImageCategorie("piano_droit01.png");
      $c2->setTypeCategorie("Pianodroit01");
      $manager->persist($c2);

      $c3 = new Categorie();
      $c3->setNomCategorie("flute traversiere");
      $c3->setDescriptionCategorie(". . .");
      $c3->setImageCategorie("flute_tra01.png");
      $c3->setTypeCategorie("FluteTra01");
      $manager->persist($c3);

      $p1 = new Produit();
      $p1->setNomProduit("Stratone");
      $p1->setDescriptionProduit("Startone guitare pour débuter tout jeune");
      $p1->setPhotoProduit("guitare_enfant.png");
      $p1->setPrixProduit(32.56);
      $manager->persist($p1);

      $p1->setCategorie($sc1);


      $manager->flush();
  }
}
?>