<?php

// src/AppBundle/Form/RepasType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Produit;

class RepasType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('date', DateType::class, [
          'widget' => 'single_text'
      ]);

      $builder->add('type', ChoiceType::class, array(
          'choices' => array(
              'Petit-déjeuner' => 'Petit-déjeuner',
              'Déjeuner' => 'Déjeuner',
              'Encas' => 'Encas',
              'Dîner' => 'Dîner',
          )
      ));


      $builder->add('produits', EntityType::class, array(
          // looks for choices from this entity
          'class'        => Produit::class,
          'choice_label' => 'codeBarre',
          'multiple' => true,

          // used to render a select box, check boxes or radios
          // 'multiple' => true,
          // 'expanded' => true,
      ));

    }
}
