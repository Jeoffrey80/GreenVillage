<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Catégorie 1 : Cordes
        $categorie1 = new Categorie();
        $categorie1->setNom('Cordes');
        $categorie1->setImage('corde1.png');

        // Sous-catégories de Cordes
        $sousCategorie11 = new Categorie();
        $sousCategorie11->setNom('Guitares');
        $sousCategorie11->setImage('guitare1.png');
        $sousCategorie11->setParent($categorie1);

        // Produits de Sous-catégorie de Cordes
        $produit1 = new Produit();
        $produit1->setNom('Fender 59 Strat NOS FR');
        $produit1->setImage('guitare2.png');
        $produit1->setDescription('Guitare électrique sillet en or');
        $produit1->setPrix('4779');
        $sousCategorie11->addProduit($produit1);
        $categorie1->addSousCategory($sousCategorie11);


        $sousCategorie12 = new Categorie();
        $sousCategorie12->setNom('Violons');
        $sousCategorie12->setImage('violon1.png');
        $sousCategorie12->setParent($categorie1);

        $produit2 = new Produit();
        $produit2->setNom('Startone Student I Violin Set 4/4');
        $produit2->setImage('violon2.png');
        $produit2->setDescription('Set violon 4/4');
        $produit2->setPrix('79');
        $sousCategorie12->addProduit($produit2);
        $categorie1->addSousCategory($sousCategorie12);

        $sousCategorie13 = new Categorie();
        $sousCategorie13->setNom('Violoncelles');
        $sousCategorie13->setImage('violoncelles1.png');
        $sousCategorie13->setParent($categorie1);

        $produit3 = new Produit();
        $produit3->setNom('Thomann Classic Cello Set 4/4');
        $produit3->setImage('violoncelle2.png');
        $produit3->setDescription('Les réglages fins de cet instrument sont effectués en Allemagne dans les ateliers de lutherie Thomann.');
        $produit3->setPrix('469');
        $sousCategorie13->addProduit($produit3);
        $categorie1->addSousCategory($sousCategorie13);

        // Persist et flush de Catégorie 1 et ses sous-catégories
        $manager->persist($categorie1);
        $manager->persist($sousCategorie11);
        $manager->persist($sousCategorie12);
        $manager->persist($sousCategorie13);
        $manager->persist($produit1);
        $manager->persist($produit2);
        $manager->persist($produit3);

        // Catégorie 2 : Vent
        $categorie2 = new Categorie();
        $categorie2->setNom('Vent');
        $categorie2->setImage('vent1.png');

        // Sous-catégories de Vent
        $sousCategorie21 = new Categorie();
        $sousCategorie21->setNom('Flûtes');
        $sousCategorie21->setImage('flute1.png');
        $sousCategorie21->setParent($categorie2);

        $sousCategorie22 = new Categorie();
        $sousCategorie22->setNom('Saxophones');
        $sousCategorie22->setImage('saxophone1.png');
        $sousCategorie22->setParent($categorie2);

        $sousCategorie23 = new Categorie();
        $sousCategorie23->setNom('Trompettes');
        $sousCategorie23->setImage('trompette1.png');
        $sousCategorie23->setParent($categorie2);

        // Persist et flush de Catégorie 2 et ses sous-catégories
        $manager->persist($categorie2);
        $manager->persist($sousCategorie21);
        $manager->persist($sousCategorie22);
        $manager->persist($sousCategorie23);

        // Catégorie 3 : Percussions
        $categorie3 = new Categorie();
        $categorie3->setNom('Percussions');
        $categorie3->setImage('percussions1.png');

        // Sous-catégories de Percussions
        $sousCategorie31 = new Categorie();
        $sousCategorie31->setNom('Batteries');
        $sousCategorie31->setImage('batterie1.png');
        $sousCategorie31->setParent($categorie3);

        $sousCategorie32 = new Categorie();
        $sousCategorie32->setNom('Xylophones');
        $sousCategorie32->setImage('xylophone1.png');
        $sousCategorie32->setParent($categorie3);

        $sousCategorie33 = new Categorie();
        $sousCategorie33->setNom('Tambours');
        $sousCategorie33->setImage('tambour1.png');
        $sousCategorie33->setParent($categorie3);

        // Persist et flush de Catégorie 3 et ses sous-catégories
        $manager->persist($categorie3);
        $manager->persist($sousCategorie31);
        $manager->persist($sousCategorie32);
        $manager->persist($sousCategorie33);

        // Catégorie 4 : Claviers
        $categorie4 = new Categorie();
        $categorie4->setNom('Claviers');
        $categorie4->setImage('clavier1.png');

        // Sous-catégories de Claviers
        $sousCategorie41 = new Categorie();
        $sousCategorie41->setNom('Pianos');
        $sousCategorie41->setImage('piano1.png');
        $sousCategorie41->setParent($categorie4);

        $sousCategorie42 = new Categorie();
        $sousCategorie42->setNom('Orgues');
        $sousCategorie42->setImage('orgue1.png');
        $sousCategorie42->setParent($categorie4);

        $sousCategorie43 = new Categorie();
        $sousCategorie43->setNom('Synthétiseurs');
        $sousCategorie43->setImage('synthétiseur1.png');
        $sousCategorie43->setParent($categorie4);

        // Persist et flush de Catégorie 4 et ses sous-catégories
        $manager->persist($categorie4);
        $manager->persist($sousCategorie41);
        $manager->persist($sousCategorie42);
        $manager->persist($sousCategorie43);

        // Catégorie 5 : Accessoires
        $categorie5 = new Categorie();
        $categorie5->setNom('Accessoires');
        $categorie5->setImage('accessoire1.png');

        // Sous-catégories de Accessoires
        $sousCategorie51 = new Categorie();
        $sousCategorie51->setNom('Étuis et Housses');
        $sousCategorie51->setImage('etuihousse1.png');
        $sousCategorie51->setParent($categorie5);

        $sousCategorie52 = new Categorie();
        $sousCategorie52->setNom('Accordeurs');
        $sousCategorie52->setImage('accordeurs1.png');
        $sousCategorie52->setParent($categorie5);

        $sousCategorie53 = new Categorie();
        $sousCategorie53->setNom('Capodastres');
        $sousCategorie53->setImage('capodastre1.png');
        $sousCategorie53->setParent($categorie5);

        // Persist et flush de Catégorie 5 et ses sous-catégories
        $manager->persist($categorie5);
        $manager->persist($sousCategorie51);
        $manager->persist($sousCategorie52);
        $manager->persist($sousCategorie53);

        // Flush toutes les données enregistrées
        $manager->flush();
    }
}
