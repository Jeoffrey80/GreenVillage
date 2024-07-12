<?php
// src/Form/ProduitType.php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\Fournisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('prix')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.parent IS NOT NULL')
                        ->orderBy('c.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une catégorie',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'ref_fournisseur', // Assurez-vous que 'reference' est une propriété de votre entité Fournisseur
                'placeholder' => 'Choisir un fournisseur',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ]);

        if ($options['modifier_image']) {
            $builder
                ->add('image', FileType::class, [
                    'label' => 'Image du produit',
                    'required' => false,
                    'mapped' => false, // Ne pas mapper ce champ à une propriété d'entité
                    'attr' => ['class' => 'form-control-file'],
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'modifier_image' => true,
        ]);

        $resolver->setAllowedTypes('modifier_image', 'bool');
    }
}
