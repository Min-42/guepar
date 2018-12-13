<?php

namespace App\Form;

use App\Entity\Sirene;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SireneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('critere', TextType::class, [
                'label' => false, 
                'attr' => [
                    'placeholder' => 'Code siren/Nom de l\'entreprise',
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sirene::class,
            'attr' => ['id' => 'frmSirene']
        ]);
    }
}
