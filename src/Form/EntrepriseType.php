<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeSiren', TextType::class, [
                'label' => 'Code siren', 
                'attr' => [
                    'placeholder' => 'Code Siren de l\'entreprise',
                ]])
            ->add('nom', TextType::class, [
                'label' => 'Nom', 
                'attr' => [
                    'placeholder' => 'Nom de l\'entreprise',
                ]])
            ->add('contacts', TextareaType::class, [
                'label' => 'Contacts', 
                'attr' => [
                    'placeholder' => 'Contacts dans l\'entreprise',
                ]])
            ->add('conventionCollective', TextType::class, [
                'label' => 'Convention collective', 
                'attr' => [
                    'placeholder' => 'ID de la Convention Collective',
                ]])
            ->add('trancheEffectifs', TextType::class, [
                'label' => 'Tranche d\'effectifs', 
                'attr' => [
                    'placeholder' => 'Tranche d\'effectifs de l\'entreprise',
                ]])
            ->add('nbAdherents', IntegerType::class, [
                'label' => 'Nombre d\'adhérents', 
                'attr' => [
                    'placeholder' => 'Nombre d\'adhérents dans l\'entreprise',
                ]])
            ->add('notes', TextareaType::class, [
                'label' => 'Notes', 
                'attr' => [
                    'placeholder' => 'Notes concernant l\'entreprise',
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
