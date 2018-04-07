<?php

// src/AppBundle/Form/RepasType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
    }
}
