<?php
namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class FormNoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('noteLamp', IntegerType::class, [
                'label' => 'Votre note pour cette lampe',
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'placeholder' => 'Donnez une note entre 1 et 5',
                ],
                'required' => true, // Rendre ce champ obligatoire
                'invalid_message' => 'Veuillez entrer un nombre valide entre 1 et 5.',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
