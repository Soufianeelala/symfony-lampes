<?php

namespace App\Form;

use App\Entity\Lamp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FormLampType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            // Champ pour l'image
            ->add('imageFile', FileType::class, [
                'required' => false,   // Le champ n'est pas obligatoire
                'mapped' => true,     // Le champ 'imageFile' n'est pas mappé dans la base de données
                'constraints' => [
                    new File([
                        'maxSize' => '2M',  // Taille maximale du fichier
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG, GIF).',
                    ]),
                ],
            ])
            ->add('description')
            ->add('value')
            ->add('creates_at', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lamp::class,
        ]);
    }
}
