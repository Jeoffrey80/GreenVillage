<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajoute un champ 'libelle' de type texte
        $builder->add('Nom')

        // Ajoute un champ 'description' de type texte
            ->add('description')

        // Ajoute un champ 'prix' de type texte
            ->add('prix')

        // Ajoute un champ 'active' de type checkbox
            ->add('active')

        // Ajoute un champ 'categorie' de type texte
            ->add('categorie');

        // Ajoute le champ 'image' de type FileType uniquement si l'option 'modifier_image' est true
        if ($options['modifier_image'] ?? true) {
            $builder->add('image', FileType::class, [
                'label' => 'Image du produit',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configure les options du formulaire, notamment pour traiter un objet de la classe Plats
        $resolver->setDefaults([
            'data_class' => Produit::class,
            'modifier_image' => true,
        ]);

        // Permet uniquement le type 'bool' pour l'option 'modifier_image'
        $resolver->setAllowedTypes('modifier_image', 'bool');
    }
}