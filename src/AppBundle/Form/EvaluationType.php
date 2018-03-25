<?php

// src/Form/TaskType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('commentaire', TextareaType::class, array(
          'attr' => array('placeholder' => 'Un commentaire'),
      ));

      $builder->add('note', ChoiceType::class, array(
          'choices' => array(
              '0' => 0,
              '1' => 1,
              '2' => 2,
              '3' => 3,
              '4' => 4,
              '5' => 5,
          )
      ));

    }
}
