<?php
namespace App\DataFixtures;

use App\Entity\Famille;
use App\Entity\Type;
use App\Entity\SousType;
use App\Entity\Modele;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JeuProduit extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         
        $famille1 = new Famille();
        $famille1->setNom("Famille à cordes");
        $famille1->setImage("fam1.png");
        $manager->persist($famille1);

        $type1 = new Type();
        $type1->setNom("Cordes Frottées");
        $type1->setImage("type1.png");
        $type1->setFamille($famille1);
        $manager->persist($type1);

        $soustype1 = new SousType();
        $soustype1->setNom("Sans Type");
        $soustype1->setImage("sanstyp1.png");
        $soustype1->setType($type1);
        $manager->persist($soustype1);

        $modele1 = new Modele();
        $modele1->setNom("Violon");
        $modele1->setImage("violon1.png");
        $modele1->setSousType($soustype1);
        $manager->persist($modele1);
        
        $produit1 = new Produit();
        $produit1->setNom("violon tutu");
        $produit1->setDescription("tutulututu");
        $produit1->setImage("prod1.png");
        $produit1->setPrix("59.99");
        $produit1->setModele($modele1);
        $manager->persist($produit1);

        $manager->flush();
    }
}