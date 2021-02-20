<?php

namespace App\Form\Type;
use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire de film
 */
class FilmType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre',
                    'attr' => [
                        'max_length' => '255'
                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'Résumé',
                    'required' => false
                ]
            )
            ->add(
                'releaseDate',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'format' => "dd/MM/yyyy",
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker'
                    ]
                ]
            )
            ->add(
                'characters',
                CollectionType::class,
                [
                    'entry_type' => CharacterType::class,
                    'allow_add' => true,
                    'label' => 'Personnages'
                ]
            )
        ;
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Film::class);
    }
}
