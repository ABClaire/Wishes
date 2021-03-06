<?php

namespace App\Form;

use App\Entity\Wish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThan;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ["attr"=> ['placeholder' => 'Votre titre ici']])
            ->add('description')
            ->add('author')
            ->add('categorie', null, ['choice_label'=>'libelle'])
            ->add('dateNaissance', DateType::class, 
                    [
                        'mapped' => false,
                        'widget' => 'single_text',
                        'format' => 'yyyy-MM-dd',
                        'constraints' => [new LessThan('-18 years')]
                    ],
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
