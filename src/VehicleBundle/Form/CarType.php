<?php

namespace VehicleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Brand', 'entity', array(
                    'class' => 'VehicleBundle:Brand',
                    'choice_label' => 'name',))
                ->add('Model', 'entity', array(
                    'class' => 'VehicleBundle:Model',
                    'choice_label' => 'name',))
                ->add('fuel')
                ->add('capacity')
                ->add('power')
                ->add('firstRegistration', 'date', array (
                    'label' => "First Registration",
                    'translation_domain' => 'messages',
                    'years' => range(date('Y') - 36, date('Y')),
                    'data' => new \DateTime()
                ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VehicleBundle\Entity\Car'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vehiclebundle_car';
    }


}
