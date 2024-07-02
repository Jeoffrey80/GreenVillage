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
    //Partie Famille
        $famille1 = new Famille();
        $famille1->setNom("Famille à cordes");
        $famille1->setImage("fam1.png");
        $manager->persist($famille1);

        $famille2 = new Famille();
        $famille2->setNom("Famille des instruments à vent");
        $famille2->setImage("fam2.png");
        $manager->persist($famille2);

        $famille3 = new Famille();
        $famille3->setNom("Famille des percussion");
        $famille3->setImage("fam3.png");
        $manager->persist($famille3);
    //--------------------------------------------------------------

    //Partie Type
        $type1 = new Type();
        $type1->setNom("Cordes frottées");
        $type1->setImage("type1.png");
        $type1->setFamille($famille1);
        $manager->persist($type1);

        $type2 = new Type();
        $type2->setNom("Cordes pincées");
        $type2->setImage("type2.png");
        $type2->setFamille($famille1);
        $manager->persist($type2);

        $type3 = new Type();
        $type3->setNom("Cordes frappées");
        $type3->setImage("type3.png");
        $type3->setFamille($famille1);
        $manager->persist($type3);

        $type4 = new Type();
        $type4->setNom("Famille des bois");
        $type4->setImage("type4.png");
        $type4->setFamille($famille2);
        $manager->persist($type4);

        $type5 = new Type();
        $type5->setNom("Famille des cuivres");
        $type5->setImage("type5.png");
        $type5->setFamille($famille2);
        $manager->persist($type5);

        $type6 = new Type();
        $type6->setNom(" Instruments à sons déterminés");
        $type6->setImage("type6.png");
        $type6->setFamille($famille3);
        $manager->persist($type6);

        $type7 = new Type();
        $type7->setNom(" Instruments à sons indéterminés");
        $type7->setImage("type7.png");
        $type7->setFamille($famille3);
        $manager->persist($type7);

        $type8 = new Type();
        $type8->setNom(" Batterie");
        $type8->setImage("type8.png");
        $type8->setFamille($famille3);
        $manager->persist($type8);
    // --------------------------------------------------------------

    //Partie Sous Type
        $sanssoustype1 = new SousType();
        $sanssoustype1->setNom("Sans Sous Type");
        $sanssoustype1->setImage("sanssstyp1.png");
        $sanssoustype1->setType($type1);
        $manager->persist($sanssoustype1);

        $sanssoustype2 = new SousType();
        $sanssoustype2->setNom("Sans Sous Type");
        $sanssoustype2->setImage("sanssstyp2.png");
        $sanssoustype2->setType($type6);
        $manager->persist($sanssoustype2);

        $sanssoustype3 = new SousType();
        $sanssoustype3->setNom("Sans Sous Type");
        $sanssoustype3->setImage("sanssstyp3.png");
        $sanssoustype3->setType($type7);
        $manager->persist($sanssoustype3);

        $sanssoustype4 = new SousType();
        $sanssoustype4->setNom("Sans Sous Type");
        $sanssoustype4->setImage("sanssstyp4.png");
        $sanssoustype4->setType($type8);
        $manager->persist($sanssoustype4);

        $sanssoustype5 = new SousType();
        $sanssoustype5->setNom("Sans Sous Type");
        $sanssoustype5->setImage("sanssstyp5.png");
        $sanssoustype5->setType($type3);
        $manager->persist($sanssoustype5);

        $sanssoustype6 = new SousType();
        $sanssoustype6->setNom("Sans Sous Type");
        $sanssoustype6->setImage("sanssstyp6.png");
        $sanssoustype6->setType($type5);
        $manager->persist($sanssoustype6);


        $soustype2 = new SousType();
        $soustype2->setNom("à l'aide des doigts");
        $soustype2->setImage("soustyp1.png");
        $soustype2->setType($type2);
        $manager->persist($soustype2);

        $soustype3 = new SousType();
        $soustype3->setNom("à l'aide d'un clavier");
        $soustype3->setImage("soustyp2.png");
        $soustype3->setType($type2);
        $manager->persist($soustype3);

        $soustype4 = new SousType();
        $soustype4->setNom("Instruments à biseau");
        $soustype4->setImage("soustyp3.png");
        $soustype4->setType($type4);
        $manager->persist($soustype4);

        $soustype5 = new SousType();
        $soustype5->setNom("Instruments à anche double");
        $soustype5->setImage("soustyp4.png");
        $soustype5->setType($type4);
        $manager->persist($soustype5);

        $soustype6 = new SousType();
        $soustype6->setNom("Instruments à anche simple");
        $soustype6->setImage("soustyp5.png");
        $soustype6->setType($type4);
        $manager->persist($soustype6);
    //--------------------------------------------------------------

    //Partie Modele
        $modele1 = new Modele();
        $modele1->setNom("Violon");
        $modele1->setImage("violon1.png");
        $modele1->setSousType($sanssoustype1);
        $manager->persist($modele1);

        $modele2 = new Modele();
        $modele2->setNom("Alto");
        $modele2->setImage("alto1.png");
        $modele2->setSousType($sanssoustype1);
        $manager->persist($modele2);

        $modele3 = new Modele();
        $modele3->setNom("Violoncelle");
        $modele3->setImage("violoncelle1.png");
        $modele3->setSousType($sanssoustype1);
        $manager->persist($modele3);

        $modele4 = new Modele();
        $modele4->setNom("Contrebasse");
        $modele4->setImage("contrebasse1.png");
        $modele4->setSousType($sanssoustype1);
        $manager->persist($modele4);

        $modele5 = new Modele();
        $modele5->setNom("Viole de gambe");
        $modele5->setImage("violedegamne1.png");
        $modele5->setSousType($sanssoustype1);
        $manager->persist($modele5);

        $modele6 = new Modele();
        $modele6->setNom("Octobasse");
        $modele6->setImage("octobasse1.png");
        $modele6->setSousType($sanssoustype1);
        $manager->persist($modele6);

        $modele7 = new Modele();
        $modele7->setNom("Banjo");
        $modele7->setImage("banjo1.png");
        $modele7->setSousType($soustype2);
        $manager->persist($modele7);

        $modele8 = new Modele();
        $modele8->setNom("Contrebassine");
        $modele8->setImage("contrebassine1.png");
        $modele8->setSousType($soustype2);
        $manager->persist($modele8);

        $modele9 = new Modele();
        $modele9->setNom("Guitare");
        $modele9->setImage("guitare1.png");
        $modele9->setSousType($soustype2);
        $manager->persist($modele9);

        $modele10 = new Modele();
        $modele10->setNom("Harpe");
        $modele10->setImage("harpe1.png");
        $modele10->setSousType($soustype2);
        $manager->persist($modele10);

        $modele11 = new Modele();
        $modele11->setNom("Luth");
        $modele11->setImage("luth1.png");
        $modele11->setSousType($soustype2);
        $manager->persist($modele11);

        $modele12 = new Modele();
        $modele12->setNom("Lyre");
        $modele12->setImage("lyre1.png");
        $modele12->setSousType($soustype2);
        $manager->persist($modele12);

        $modele13 = new Modele();
        $modele13->setNom("Mandoline");
        $modele13->setImage("mandoline1.png");
        $modele13->setSousType($soustype2);
        $manager->persist($modele13);

        $modele14 = new Modele();
        $modele14->setNom("Gouroumi");
        $modele14->setImage("gouroumi1.png");
        $modele14->setSousType($soustype2);
        $manager->persist($modele14);

        $modele15 = new Modele();
        $modele15->setNom("Clavecin");
        $modele15->setImage("clavecin1.png");
        $modele15->setSousType($soustype3);
        $manager->persist($modele15);

        $modele16 = new Modele();
        $modele16->setNom("Epinette");
        $modele16->setImage("epinette1.png");
        $modele16->setSousType($soustype3);
        $manager->persist($modele16);

        $modele17 = new Modele();
        $modele17->setNom("Piano");
        $modele17->setImage("piano1.png");
        $modele17->setSousType($soustype3);
        $manager->persist($modele17);

        $modele18 = new Modele();
        $modele18->setNom("Cymbalum");
        $modele18->setImage("cymbalum1.png");
        $modele18->setSousType($sanssoustype5);
        $manager->persist($modele18);

        $modele19 = new Modele();
        $modele19->setNom("Piano");
        $modele19->setImage("piano2.png");
        $modele19->setSousType($sanssoustype5);
        $manager->persist($modele19);

        $modele20 = new Modele();
        $modele20->setNom("Flûte à bec");
        $modele20->setImage("flutebec1.png");
        $modele20->setSousType($soustype4);
        $manager->persist($modele20);

        $modele21 = new Modele();
        $modele21->setNom("Flûte traversière");
        $modele21->setImage("flutetraversiere1.png");
        $modele21->setSousType($soustype4);
        $manager->persist($modele21);

        $modele22 = new Modele();
        $modele22->setNom("Hautbois");
        $modele22->setImage("hautbois1.png");
        $modele22->setSousType($soustype5);
        $manager->persist($modele22);

        $modele23 = new Modele();
        $modele23->setNom("Basson");
        $modele23->setImage("basson1.png");
        $modele23->setSousType($soustype5);
        $manager->persist($modele23);

        $modele24 = new Modele();
        $modele24->setNom("contrebasson");
        $modele24->setImage("contrebasson1.png");
        $modele24->setSousType($soustype5);
        $manager->persist($modele24);

        $modele25 = new Modele();
        $modele25->setNom("Cor anglais");
        $modele25->setImage("coranglais1.png");
        $modele25->setSousType($soustype5);
        $manager->persist($modele25);

        $modele26 = new Modele();
        $modele26->setNom("Clarinette");
        $modele26->setImage("clarinette1.png");
        $modele26->setSousType($soustype6);
        $manager->persist($modele26);

        $modele27 = new Modele();
        $modele27->setNom("Saxophone");
        $modele27->setImage("saxophone1.png");
        $modele27->setSousType($soustype6);
        $manager->persist($modele27);

        $modele28 = new Modele();
        $modele28->setNom("Trompette");
        $modele28->setImage("trompette1.png");
        $modele28->setSousType($sanssoustype6);
        $manager->persist($modele28);

        $modele29 = new Modele();
        $modele29->setNom("Cor d'harmonie");
        $modele29->setImage("corharmonie1.png");
        $modele29->setSousType($sanssoustype6);
        $manager->persist($modele29);

        $modele30 = new Modele();
        $modele30->setNom("Trombonne");
        $modele30->setImage("trombonne1.png");
        $modele30->setSousType($sanssoustype6);
        $manager->persist($modele30);

        $modele31 = new Modele();
        $modele31->setNom("Tuba");
        $modele31->setImage("tuba1.png");
        $modele31->setSousType($sanssoustype6);
        $manager->persist($modele31);

        $modele32 = new Modele();
        $modele32->setNom("Xylophone");
        $modele32->setImage("xylophone1.png");
        $modele32->setSousType($sanssoustype2);
        $manager->persist($modele32);

        $modele33 = new Modele();
        $modele33->setNom("Vibraphone");
        $modele33->setImage("vibraphone1.png");
        $modele33->setSousType($sanssoustype2);
        $manager->persist($modele33);

        $modele34 = new Modele();
        $modele34->setNom("Marimba");
        $modele34->setImage("Marimba1.png");
        $modele34->setSousType($sanssoustype2);
        $manager->persist($modele34);

        $modele35 = new Modele();
        $modele35->setNom("Timbales");
        $modele35->setImage("timbales1.png");
        $modele35->setSousType($sanssoustype2);
        $manager->persist($modele35);

        $modele36 = new Modele();
        $modele36->setNom("Tongue drum");
        $modele36->setImage("tonguedrum1.png");
        $modele36->setSousType($sanssoustype2);
        $manager->persist($modele36);
        
        $modele37 = new Modele();
        $modele37->setNom("Caisse claire");
        $modele37->setImage("caisseclaire1.png");
        $modele37->setSousType($sanssoustype3);
        $manager->persist($modele37);

        $modele38 = new Modele();
        $modele38->setNom("Grosse caisse");
        $modele38->setImage("grossecaisse1.png");
        $modele38->setSousType($sanssoustype3);
        $manager->persist($modele38);

        $modele39 = new Modele();
        $modele39->setNom("Toms");
        $modele39->setImage("tom1.png");
        $modele39->setSousType($sanssoustype3);
        $manager->persist($modele39);

        $modele40 = new Modele();
        $modele40->setNom("Cymbales");
        $modele40->setImage("cymbale1.png");
        $modele40->setSousType($sanssoustype3);
        $manager->persist($modele40);

        $modele41 = new Modele();
        $modele41->setNom("Tambour");
        $modele41->setImage("tambour1.png");
        $modele41->setSousType($sanssoustype3);
        $manager->persist($modele41);

        $modele42 = new Modele();
        $modele42->setNom("Tambourin");
        $modele42->setImage("tambourin1.png");
        $modele42->setSousType($sanssoustype3);
        $manager->persist($modele42);

        $modele43 = new Modele();
        $modele43->setNom("Triangle");
        $modele43->setImage("triangle1.png");
        $modele43->setSousType($sanssoustype3);
        $manager->persist($modele43);

        $modele44 = new Modele();
        $modele44->setNom("Castagnettes");
        $modele44->setImage("castagnettes1.png");
        $modele44->setSousType($sanssoustype3);
        $manager->persist($modele44);

        $modele45 = new Modele();
        $modele45->setNom("Claves");
        $modele45->setImage("clave1.png");
        $modele45->setSousType($sanssoustype3);
        $manager->persist($modele45);

        $modele46 = new Modele();
        $modele46->setNom("Gong");
        $modele46->setImage("gong1.png");
        $modele46->setSousType($sanssoustype3);
        $manager->persist($modele46);

        $modele47 = new Modele();
        $modele47->setNom("Caixa");
        $modele47->setImage("caixa1.png");
        $modele47->setSousType($sanssoustype3);
        $manager->persist($modele47);

        $modele48 = new Modele();
        $modele48->setNom("Tamborim");
        $modele48->setImage("tamborim1.png");
        $modele48->setSousType($sanssoustype3);
        $manager->persist($modele48);

        $modele49 = new Modele();
        $modele49->setNom("Batterie");
        $modele49->setImage("batterie1.png");
        $modele49->setSousType($sanssoustype4);
        $manager->persist($modele49);
    //--------------------------------------------------------------

    //Partie Produit
        $produit1 = new Produit();
        $produit1->setNom("Violon Gliga Gems 2 Gaucher 4/4");
        $produit1->setDescription("Sa forme Stradivari lui confère des qualités sonores exceptionnelles. 
        Notre violon est constitué d’une table en épicéa massif des Carpates, ce type de bois est réputé pour sa sublime acoustique.");
        $produit1->setImage("prod1.png");
        $produit1->setPrix("585.96");
        $produit1->setModele($modele1);
        $manager->persist($produit1);

        $produit2 = new Produit();
        $produit2->setNom("Banjo Thomann Dulcimer");
        $produit2->setDescription("4 cordes, Table en épicéa, 3 rosaces
    ");
        $produit2->setImage("prod2.png");
        $produit2->setPrix("189.95");
        $produit2->setModele($modele7);
        $manager->persist($produit2);

        $produit3 = new Produit();
        $produit3->setNom("Clavecin numérique Roland C50 ");
        $produit3->setDescription("Clavecin numérique style old");
        $produit3->setImage("prod3.png");
        $produit3->setPrix("2689.96");
        $produit3->setModele($modele15);
        $manager->persist($produit3);

        $produit4 = new Produit();
        $produit4->setNom("Cymbalum");
        $produit4->setDescription("En bois sculpté de fleurs et feuillages sur les bordures.
        Avec baguettes. XXeme siècle.");
        $produit4->setImage("prod4.png");
        $produit4->setPrix("195.54");
        $produit4->setModele($modele18);
        $manager->persist($produit4);

        $produit5 = new Produit();
        $produit5->setNom("Moeck 1212 School Soprano Recorder");
        $produit5->setDescription("Flûte à bec soprano -Corps en poirier naturel
        -Doigté baroque
        -Double trou
        -Trousse en nylon incl.");
        $produit5->setImage("prod5.png");
        $produit5->setPrix("75.89");
        $produit5->setModele($modele20);
        $manager->persist($produit5);

        $produit6 = new Produit();
        $produit6->setNom("RIGOUTAT RIEC HAUTBOIS D'ETUDE avec étui sacoche ");
        $produit6->setDescription("• Système à  plateaux
        • Clé de 1ère octave");
        $produit6->setImage("prod6.png");
        $produit6->setPrix("4125.66");
        $produit6->setModele($modele22);
        $manager->persist($produit6);

        $produit7 = new Produit();
        $produit7->setNom("Yamaha YCL-255 S Bb-Clarinet");
        $produit7->setDescription("blbblblblblbl");
        $produit7->setImage("prod7.png");
        $produit7->setPrix("589.99");
        $produit7->setModele($modele26);
        $manager->persist($produit7);

        $produit8 = new Produit();
        $produit8->setNom("Thomann Alto Xylophone TAX");
        $produit8->setDescription("
        Xylophone alto
            Tessiture: Do1 - La2
            Lames de Fa#1, Sib1 et Fa#2 incl.
        ");
        $produit8->setImage("prod8.png");
        $produit8->setPrix("169.99");
        $produit8->setModele($modele32);
        $manager->persist($produit8);

        $produit9 = new Produit();
        $produit9->setNom("Millenium SD-17 Snare Drum Starter Kit");
        $produit9->setDescription(" Set caisse claire");
        $produit9->setImage("prod9.png");
        $produit9->setPrix("145.19");
        $produit9->setModele($modele37);
        $manager->persist($produit9);

        $produit10 = new Produit();
        $produit10->setNom("Yamaha Stage Custom Stand. CR- Bundle");
        $produit10->setDescription("Yamaha Stage Custom Standard -CR");
        $produit10->setImage("prod10.png");
        $produit10->setPrix("1245.99");
        $produit10->setModele($modele49);
        $manager->persist($produit10);
    //--------------------------------------------------------------

        $manager->flush();
    }
}