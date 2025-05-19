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
            ->add('imageFile', FileType::class, [
                'required' => false,   
                'mapped' => true,     
                'constraints' => [
                    new File([
                        'maxSize' => '5M',  
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
            // ->add('creates_at', null, [
            //     'widget' => 'single_text',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lamp::class,
        ]);
    }
}
